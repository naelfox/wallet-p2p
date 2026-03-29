<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // mil em centavos
    private $defaultMoney = 100000;

    public function run(): void
    {
        // usuario fixo
        $user = User::create([
            'name' => 'Natanael',
            'email' => 'natanaelvila2@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->wallet()->create([
            'balance' => $this->defaultMoney,
        ]);

        // usuarios fake
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                $user->wallet()->create([
                    'balance' => $this->defaultMoney,
                ]);
            });
    }
}
