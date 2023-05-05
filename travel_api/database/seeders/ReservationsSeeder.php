<?php
use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Destination;
use Faker\Factory as FakerFactory;

class ReservationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        $users = User::all();
        $destinations = Destination::all();

        // Création de 20 réservations aléatoires
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $destination = $destinations->random();

            $reservation = new Reservation();
            $reservation->utilisateur_id = $user->id;
            $reservation->destination_id = $destination->id;
            $reservation->date_de_départ = $faker->dateTimeBetween('now', '+1 year');
            $reservation->date_de_retour = $faker->dateTimeBetween($reservation->date_de_départ, '+1 week');
            $reservation->nombre_de_voyageurs = $faker->numberBetween(1, 5);
            $reservation->option_de_paiement = $faker->randomElement(['CB', 'PayPal', 'Virement bancaire']);
            $reservation->tarif_total = $faker->randomFloat(2, 100, 1000);
            $reservation->save();
        }
    }
}
