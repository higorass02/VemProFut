<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MatchSoccer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $i = 1;
        while ($i <= 5) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'alias' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'dt_birthdate' => $faker->date(),
                'role' => rand(1,2),
                'gender' => $this->getSexo(),
                'email' => $faker->email(),
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }

        $user = DB::table('users')->select(['id'])->get()->first();

        
        DB::table('matches_soccer')->insert([
            'user_id' => $user->id,
            'status' => $this->getStatusMatch(),
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);

        $match = DB::table('users')->select(['id'])->get()->first();

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
