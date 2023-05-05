<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Destination::create([
            'nom' => 'Paris',
            'description' => 'Ville de l\'amour',
            'prix' => 100,
            'image' => 'paris.jpg',
            'emplacement' => 'France',
            'lat' => 48.856614,
            'lng' => 2.3522219,
        ]);

        Destination::create([
            'nom' => 'Finlande',
            'description' => 'Le pays du papa noël',
            'prix' => 200,
            'image' => 'laponi.jpg',
            'emplacement' => 'finlande',
            'lat' => 40.712775,
            'lng' => -74.005973,
        ]);

        // Ajouter d'autres destinations si nécessaire
    }
}
