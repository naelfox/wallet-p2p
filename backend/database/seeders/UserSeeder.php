<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // usuario fixo
        $user = User::create([
            'name' => 'Natanael',
            'email' => 'natanaelvila2@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->wallet()->create([
            'balance' => 1000
        ]);

        // usuarios fake
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                $user->wallet()->create([
                    'balance' => 1000
                ]);
            });
    }
}
