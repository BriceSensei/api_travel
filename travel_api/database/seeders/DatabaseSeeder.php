<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use ReservationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            DestinationsTableSeeder::class,
            ReservationSeeder::class,
            CommentaireSeeder::class,
            //
        ]);
    }
}
