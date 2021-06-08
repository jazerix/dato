<?php

namespace Database\Seeders;

use App\Models\Player;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $players = ['Ditlev', 'Keeny', 'Nadine', 'Christen', 'Steffen', 'Therese', 'Cecilie', 'Filosoffen', 'Niels'];
        $faker = Factory::create();

        foreach ($players as $player)
        {
            $player = Player::create([
                'name' => $player
            ]);

            /*$player->beverages()->create([
                'cost'       => $faker->randomElement([2, 3]),
                'started_at' => $faker->dateTimeBetween('-150 minutes', '-90 minutes'),
                'completed_at' => $faker->dateTimeBetween('-90 minutes', '-30 minutes'),
            ]);

            $player->beverages()->create([
                'cost'       => $faker->randomElement([2, 3]),
                'started_at' => $faker->dateTimeBetween('-150 minutes', '-90 minutes'),
                'completed_at' => $faker->dateTimeBetween('-90 minutes', '-30 minutes'),
            ]);

            $player->beverages()->create([
                'cost'       => $faker->randomElement([2, 3]),
                'started_at' => $faker->dateTimeBetween('-150 minutes', '-90 minutes'),
                'completed_at' => $faker->dateTimeBetween('-90 minutes', '-30 minutes'),
            ]);

            $player->beverages()->create([
                'cost'       => $faker->randomElement([2, 3]),
                'started_at' => $faker->dateTimeBetween('-30 minutes', 'now')
            ]);*/

        }
    }
}
