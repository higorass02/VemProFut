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
    private $payments = [];
    private $noPayments = [];
    private $tempPlayes = [];
    private $teams = null;
    private $teamsAllNames = null;
    private $maxPlayesPositions = [];
    private $countTeams = 0;

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
        $this->payments = [];
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

        //filtrar usuario pagantes
        $this->filterPayers($users);

        //instaciar limitadores por posição
        $tempPlayesPayment = $this->setUserPerPosition($this->payments);
        $tempPlayesNoPayment = $this->setUserPerPosition($this->noPayments);
        
        $countPlayers = count($users);

        if(isset($tempPlayesPayment['goalKeeper'])){
            $countPlayers -= count($tempPlayesPayment['goalKeeper']);
        }
        if(isset($tempPlayesNoPayment['goalKeeper'])){
            $countPlayers -= count($tempPlayesNoPayment['goalKeeper']);
        }
        
        $maxLineUp = $match->config->max_playes_line;
        $qtdTeams =(int) number_format(round($countPlayers/$maxLineUp, 1), 0);
        $this->configTeams($match->config->distinct_team, $qtdTeams);
        // dd($this->teams);
        // criar limitador de jogadores por posição
        $this->setMaxPlayersPerPosition($maxLineUp, $tempPlayesPayment);

        //metodo principal de sorteio random
        if($this->validCountPlayers($tempPlayesPayment) > 0){
            $this->sortingPlayes($tempPlayesPayment, $maxLineUp);
        }

        if($this->validCountPlayers($tempPlayesNoPayment) > 0){
            $this->sortingPlayes($tempPlayesNoPayment, $maxLineUp, 'Convidados');
        }

        // dd($this->noPayments);
        dd($this->teams);
        // }
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

    private function filterPayers($users)
    {
        foreach($users as $user){
            if($user->payer){
                $this->payments[] = $user;
            }else{
                $this->noPayments[] = $user;
            }
        }
    }
    private function setUserPerPosition($playes)
    {
        $tempPlayes = null;

        foreach($playes as $userPayer){
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
        return $tempPlayes;
    }
    private function configTeams($distinctTeam, $qtdTeams)
    {
        //criar quantidade de timer
        if($distinctTeam == MatchConfig::TEAM_DISTINCT_NUMBER){
            $i = 1;
            while($i <= $qtdTeams){
                $this->teams[$i]['goalKeeper'] = [];
                $this->teams[$i]['defencer'] = [];
                $this->teams[$i]['left'] = [];
                $this->teams[$i]['right'] = [];
                $this->teams[$i]['mid'] = [];
                $this->teams[$i]['forward'] = [];
                $this->teamsAllNames[$i] = [];
                $i++;
            }
        }
        $this->countTeams = count($this->teams);
    }

    private function setMaxPlayersPerPosition($limit, $tempPlayesPayment)
    {
        $totPlayersLineup = 0;
        foreach($tempPlayesPayment as $keyPosition => $value){            
            if($keyPosition == 'goalKeeper'){
                $this->maxPlayesPositions[$keyPosition] = 1;
            }else{
                if($totPlayersLineup <= $limit){
                    $maxPosition = (int) number_format(round(count($value)/$this->countTeams, 1), 0);
                    if($totPlayersLineup + $maxPosition <= $limit){
                        $totPlayersLineup += $maxPosition;
                        $this->maxPlayesPositions[$keyPosition] = $maxPosition;
                    }
                }
            }
        }
    }
    private function sortingPlayes($players, $limit, $convidado = null)
    {
        $indexTeam = 1;
        //percorer times para preencher
        while($indexTeam <= count($this->teams)){
            // var_dump('contador time '.$indexTeam);
            // var_dump(count($this->teamsAllNames[$indexTeam]));
            // var_dump($limit);
            if(count($this->teamsAllNames[$indexTeam]) > $limit+1){
                $indexTeam++;
            }
            //percorer jogadores 
            foreach($players as $keyPosition => $value){
                //preencher times
                //validar se possuem opções para sortear
                if($convidado){
                    // var_dump($value);
                    // var_dump('--------------');
                    // var_dump(is_array($value));
                    // var_dump(!empty($value));
                }
                if(is_array($value) && !empty($value)){
                    // var_dump(1);
                    if(isset($this->maxPlayesPositions[$keyPosition])){
                        // var_dump(2);
                        //valida se possuem jogadores suficientes para sortear
                        if(count($value) > $this->maxPlayesPositions[$keyPosition]){
                            // var_dump(3);
                            //gerar sorteado por posição
                            $keySort = array_rand($value, $this->maxPlayesPositions[$keyPosition]);
                            //se houver mais de um sorteado
                            if(is_array($keySort)){
                                // var_dump(4);
                                //preenche time
                                foreach($keySort as $nkey => $nValue){
                                    //validar se ja existem jogadores maximos por posição
                                    if($this->maxPlayesPositions[$keyPosition] > count($this->teams[$indexTeam][$keyPosition])){
                                        // var_dump(5);
                                        $this->teams[$indexTeam][$keyPosition][] = $players[$keyPosition][$nValue]->name;
                                        $this->teamsAllNames[$indexTeam][] = $players[$keyPosition][$nValue]->name;
                                        unset($players[$keyPosition][$nValue]);
                                    }
                                }
                            //caso de haver apenas um jogar para a posição
                            }else{
                                // var_dump(6);
                                $this->teams[$indexTeam][$keyPosition][] = $players[$keyPosition][$keySort]->name;
                                $this->teamsAllNames[$indexTeam][] = $players[$keyPosition][$keySort]->name;
                                unset($players[$keyPosition][$keySort]);
                            }
                        //caso de exista apenas aqueles jogadores para a posição
                        }else{
                            // var_dump(7);
                            //preenche time
                            foreach($value as $nkey => $nValue){
                                if($this->maxPlayesPositions[$keyPosition] > count($this->teams[$indexTeam][$keyPosition])){
                                    $this->teams[$indexTeam][$keyPosition][] = $players[$keyPosition][$nkey]->name;
                                    $this->teamsAllNames[$indexTeam][] = $players[$keyPosition][$nkey]->name;
                                    unset($players[$keyPosition][$nkey]);
                                }
                            }
                        }
                    }else{
                        // var_dump(8);
                    }
                }else{
                    if($convidado){
                        // var_dump('sem convidados nessa posição'.$keyPosition);
                    }
                }
            }
            $indexTeam++;
        }
    }
    private function validCountPlayers(array $palyers)
    {
        $return = 0;
        foreach($palyers as $keyPosition => $player){
            if($return <= 0){
                $return = count($palyers[$keyPosition]);   
            }
        }
        return $return;
    }
}
