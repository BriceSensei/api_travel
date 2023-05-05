<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'nom' => 'John Doe',
                'email' => 'john.doe@example.com',
                'mot_de_passe' => Hash::make('password'),
                'role' => 'employé',
            ],
            [
                'nom' => 'Jane Doe',
                'email' => 'jane.doe@example.com',
                'mot_de_passe' => Hash::make('password'),
                'role' => 'client',
            ],
            [
                'nom' => 'Bob Smith',
                'email' => 'bob.smith@example.com',
                'mot_de_passe' => Hash::make('password'),
                'role' => 'client',
            ],
        ]);
    }
}
