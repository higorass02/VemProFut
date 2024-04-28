<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use App\Models\MatchConfig;
use App\Models\MatchSoccer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        DB::table('users')->insert([
            'name' => $faker->name(),
            'alias' => $faker->name(),
            'phone' => $faker->phoneNumber(),
            'dt_birthdate' => $faker->date(),
            'role' => 0,
            'gender' => $this->getSexo(),
            'email' => $faker->email(),
            'position' => User::POSITION_GOALKEEPER,
            'payer' => 1,
            'password' => Hash::make('password'),
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);

        $userAdmin = DB::table('users')->select(['id'])->get()->first();

        // goalkeeper
        $i = 1;
        while ($i <= 2) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'alias' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'dt_birthdate' => $faker->date(),
                'role' => rand(1,2),
                'gender' => $this->getSexo(),
                'email' => $faker->email(),
                'position' => User::POSITION_GOALKEEPER,
                'payer' => 1,
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }
        
        //defencer
        $i = 1;
        while ($i <= 3) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'alias' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'dt_birthdate' => $faker->date(),
                'role' => rand(1,2),
                'gender' => $this->getSexo(),
                'email' => $faker->email(),
                'position' => User::POSITION_DEFENDER,
                'payer' => 1,
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }
        
        $i = 1;
        while ($i <= 3) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'alias' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'dt_birthdate' => $faker->date(),
                'role' => rand(1,2),
                'gender' => $this->getSexo(),
                'email' => $faker->email(),
                'position' => User::POSITION_LEFT,
                'payer' => 1,
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }

        $i = 1;
        while ($i <= 3) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'alias' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'dt_birthdate' => $faker->date(),
                'role' => rand(1,2),
                'gender' => $this->getSexo(),
                'email' => $faker->email(),
                'position' => User::POSITION_RIGHT,
                'payer' => 1,
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }

        $i = 1;
        while ($i <= 3) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'alias' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'dt_birthdate' => $faker->date(),
                'role' => rand(1,2),
                'gender' => $this->getSexo(),
                'email' => $faker->email(),
                'position' => User::POSITION_MID,
                'payer' => 1,
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }

        $i = 1;
        while ($i <= 7) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'alias' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'dt_birthdate' => $faker->date(),
                'role' => rand(1,2),
                'gender' => $this->getSexo(),
                'email' => $faker->email(),
                'position' => User::POSITION_FORWARD,
                'payer' => 1,
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }

        DB::table('groups')->insert([
            'alias' => $faker->name(),
            'user_id' => $userAdmin->id,
            'status' => Group::STATUS_ENABLED,
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);

        $users = DB::table('users')->select(['id'])->get();
        $group = DB::table('groups')->select(['id'])->get()->first();

        foreach($users as $user){
            DB::table('users_groups')->insert([
                'user_id' => $user->id,
                'group_id' => $group->id,
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
        }

        DB::table('matches_soccer')->insert([
            'user_id' => $userAdmin->id,
            'group_id' => $group->id,
            'status' => $this->getStatusMatch(),
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);
        
        $match = DB::table('matches_soccer')->select(['id'])->get()->first();

        DB::table('matches_config')->insert([
            'goal_keeper_fix' => true,
            'prioritize_payers' => true,
            'max_playes_line' => 6,
            'distinct_team' => MatchConfig::TEAM_DISTINCT_NUMBER,
            'type_sortition' => MatchConfig::TYPE_SORT_RANDOM,
            'match_id' => $match->id,
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);

        $matchesConfig = DB::table('matches_config')->select(['id'])->get()->first();

        // $t = 0;
        // while ($t <= 1) {
        //     DB::table('team')->insert([
        //         'user_id' => $user->id,
        //         'match_id' => $match->id,
        //         'status' => $this->getStatusTeam(),
        //         'created_at' => new Carbon(),
        //         'updated_at' => new Carbon()
        //     ]);
        // }
    }
    function getSexo()
    {
        $array = array(User::SEXO_MASCULINO, User::SEXO_FEMININO, User::SEXO_INDEFINIDO);
        return $array[array_rand($array)];
    }

    function getStatusMatch()
    {
        $array = array(MatchSoccer::STATUS_CREATED, MatchSoccer::STATUS_FINISHED, MatchSoccer::STATUS_IN_PROGRESS);
        return $array[array_rand($array)];
    }

    function getStatusTeam()
    {
        $array = array(MatchSoccer::STATUS_CREATED, MatchSoccer::STATUS_FINISHED, MatchSoccer::STATUS_IN_PROGRESS);
        return $array[array_rand($array)];
    }
}
