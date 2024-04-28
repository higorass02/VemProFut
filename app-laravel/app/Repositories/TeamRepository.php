<?php

namespace App\Repositories;

use App\Models\MatchConfig;
use App\Models\Team;
use App\Models\User;

class TeamRepository
{
    private Team $model;
    private UserRepository $userRepository;
    private MatchSoccerRepository $matchRepository;
    private UserGroupRepository $userGroupRepository;

    public function __construct(
        ?Team $model = null,
        ?UserRepository $userRepository = null,
        ?MatchSoccerRepository $matchRepository = null,
        ?userGroupRepository $userGroupRepository = null
    )
    {
        $this->model = $model ?? new Team();
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->matchRepository = $matchRepository ?? new MatchSoccerRepository();
        $this->userGroupRepository = $userGroupRepository ?? new UserGroupRepository();
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(array $data)
    {
        $this->userValidation($data['user_id']);
        $this->matchValidation($data['match_id']);

        //buscar config da partida
        $match = $this->matchRepository->find($data['match_id']);

        //buscar usuario do grupo
        $users = $this->userGroupRepository->getUsers($match->group_id);

        $payments = [];
        foreach($users as $user){
            if($user->payer){
                $payments[] = $user;
            }
        }

        $tempPlayes['goalKeeper'] = [];
        $tempPlayes['defencer'] = [];
        $tempPlayes['mid'] = [];
        $tempPlayes['left'] = [];
        $tempPlayes['right'] = [];
        $tempPlayes['forward'] = [];

        foreach($payments as $userPayer){
            if($userPayer->position == User::POSITION_GOALKEEPER){
                $tempPlayes['goalKeeper'][] = $userPayer;
            }else if($userPayer->position == User::POSITION_DEFENDER){
                $tempPlayes['defencer'][] = $userPayer;
            }else if($userPayer->position == User::POSITION_LEFT){
                $tempPlayes['left'][] = $userPayer;
            }else if($userPayer->position == User::POSITION_RIGHT){
                $tempPlayes['right'][] = $userPayer;
            }else if($userPayer->position == User::POSITION_MID){
                $tempPlayes['mid'][] = $userPayer;
            }else if($userPayer->position == User::POSITION_FORWARD){
                $tempPlayes['forward'][] = $userPayer;
            }
        }

        $playesNumber = count($users);

        //validar config de goleiro fixo
        if($match->config->goal_keeper_fix){
            $playesNumber -= count($tempPlayes['goalKeeper']);
            $qtdTeams =(int) number_format(round($playesNumber/$match->config->max_playes_line, 1), 0);
            $teams = null;

            //criar quantidade de timer
            if($match->config->distinct_team == MatchConfig::TEAM_DISTINCT_NUMBER){
                $i = 1;
                while($i <= $qtdTeams){
                    $teams[$i] = [];
                    $i++;
                }
            }
            $countTeams = count($teams);

            // criar limitador de jogadores por posição
            $maxPlayesPositions = [];
            foreach($tempPlayes as $keyPosition2 => $value){
                $maxPlayesPositions[$keyPosition2] =(int) number_format(round(count($value)/$countTeams, 1), 0);
            }
            
            $indexTeam = 0;
            //percorer times para preencher
            while($indexTeam < count($teams)){
                //percorer jogadores 
                foreach($tempPlayes as $keyPosition => $value){
                    $teams[$indexTeam][$keyPosition] = [];
                    //preencher times
                    //validar se possuem opções para sortear
                    if(is_array($value) && !empty($value)){
                        //valida se possuem jogadores suficientes para sortear
                        if(count($value) > $maxPlayesPositions[$keyPosition]){
                            //gerar sorteado por posição
                            $keySort = array_rand($value, $maxPlayesPositions[$keyPosition]);
                            //se houver mais de um sorteado
                            if(is_array($keySort)){
                                //preenche time
                                foreach($keySort as $nkey => $nValue){
                                    //validar se ja existem jogadores maximos por posição
                                    if($maxPlayesPositions[$keyPosition] > count($teams[$indexTeam][$keyPosition])){
                                        $teams[$indexTeam][$keyPosition][] = $tempPlayes[$keyPosition][$nValue]->name;
                                        unset($tempPlayes[$keyPosition][$nValue]);
                                    }
                                }
                            //caso de haver apenas um jogar para a posição
                            }else{
                                $teams[$indexTeam][$keyPosition][] = $tempPlayes[$keyPosition][$keySort]->name;
                                unset($tempPlayes[$keyPosition][$keySort]);
                            }
                        //caso de exista apenas aqueles jogadores para a posição
                        }else{
                            //preenche time
                            foreach($value as $nkey => $nValue){
                                if($maxPlayesPositions[$keyPosition] > count($teams[$indexTeam][$keyPosition])){
                                    $teams[$indexTeam][$keyPosition][] = $tempPlayes[$keyPosition][$nkey]->name;
                                    unset($tempPlayes[$keyPosition][$nkey]);
                                }
                            }
                        }
                        
                    }
                }
                $indexTeam++;
            }
            dd($teams);
        }
        //ordernar priorização
        //1) mensalisatas
        //2) posição
        //3) 

        $this->model->user_id = $data['user_id'];
        $this->model->match_id = $data['match_id'];
        $this->model->status = Team::STATUS_ENABLED;
        $this->model->save();
        return $this->model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(array $data, $id)
    {
        $this->model = Team::find($id);
        $this->validationExist();
        $this->validationChangeStatus($data['status']);
        $this->model->status = $data['status'];
        
        $this->model->save();

        return $this->model;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        $user->delete();
    }

    private function validationChangeStatus(int $status)
    {
        if($this->model->status == $status){
            if(!in_array($status, $this->model->getStatus())){
                throw new \InvalidArgumentException('Status Invalido!');
            }
            throw new \InvalidArgumentException('Status não foi alterado!');
        }
    }
    private function validationExist()
    {
        if(is_null($this->model)){
            throw new \InvalidArgumentException("Jogador ainda não convocado para este Time");
        }
    }

    public function userValidation($userId)
    {
        if(!$this->userRepository->find($userId)){
            throw new \InvalidArgumentException('User not Found!');
        }
    }
    
    public function matchValidation($matchId)
    {
        $match = $this->matchRepository->find($matchId);
        if(!$match){
            throw new \InvalidArgumentException('Match not Found!');
        }
        if(!$match->config){
            throw new \InvalidArgumentException('Match config not Found!');
        }
    }
    public function sortPlayers($qtd, $maxPosition)
    {
        $jogadores = null;
        if($qtd > 1 && $maxPosition >1){
            $listaDeNumeros = range(0, $maxPosition-1);
            $numeros = array_rand(array_flip($listaDeNumeros), $qtd);
            
            $jogadores = array_map(function($value){
                return str_pad($value, 2, '0', STR_PAD_LEFT);   
            }, $numeros);
        }else if($qtd == 1 && $maxPosition > 1){
            $listaDeNumeros = range(0, $maxPosition-1);
            $jogadores = array_rand(array_flip($listaDeNumeros), $qtd);
        }else if($qtd <= 1 && $maxPosition == 1){
            return 'find';
        }else{
            dd($qtd, $maxPosition);
            throw new \InvalidArgumentException('Error in Process Sort');
        }
        return $jogadores;
    }
}
