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
                'nome' => $faker->name(),
                'apelido' => $faker->name(),
                'celular' => $faker->phoneNumber(),
                'dt_nasc' => $faker->date(),
                'papel' => rand(1,2),
                'sexo' => $this->getSexo(),
                'email' => $faker->email(),
                'password' => Hash::make('password'),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
            $i++;
        }

        $users = DB::table('users')->select(['id'])->get();

        foreach($users as $user){
            DB::table('matches_Soccer')->insert([
                'user_id' => $user->id,
                'status' => $this->getStatus(),
                'created_at' => new Carbon(),
                'updated_at' => new Carbon()
            ]);
        }
    }
    function getSexo()
    {
        $array = array(User::SEXO_MASCULINO, User::SEXO_FEMININO, User::SEXO_INDEFINIDO);
        return $array[array_rand($array)];
    }

    function getStatus()
    {
        $array = array(MatchSoccer::STATUS_CREATED, MatchSoccer::STATUS_FINISHED, MatchSoccer::STATUS_IN_PROGRESS);
        return $array[array_rand($array)];
    }
}
