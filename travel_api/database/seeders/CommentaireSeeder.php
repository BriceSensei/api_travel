<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commentaire;
use App\Models\User;
use App\Models\Destination;

class CommentaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer tous les utilisateurs et destinations
        $utilisateurs = user::all();
        $destinations = Destination::all();
        
        // Créer 50 commentaires aléatoires
        for ($i = 0; $i < 50; $i++) {
            Commentaire::create([
                'utilisateur_id' => $utilisateurs->random()->id,
                'destination_id' => $destinations->random()->id,
                'note' => rand(1, 5),
                'commentaire' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                   Nullam vel nisl in sapien tincidunt iaculis. Sed mollis 
                                   elementum bibendum. Duis luctus eget nunc vitae consequat. 
                                   Praesent vel nibh id libero finibus facilisis. Sed rhoncus 
                                   dui a leo pellentesque, ut vestibulum nunc gravida. 
                                   Nullam ut enim metus. Nulla facilisi. Nullam scelerisque 
                                   ligula non nisl lobortis, non volutpat orci facilisis. 
                                   Morbi ultricies lacus enim, vitae euismod massa bibendum ut.'
            ]);
        }
    }
}
