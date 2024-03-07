<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'full_name' => 'Dencel Cosme',
            'email' => '202010928@fit.edu.ph',
            'password' => Hash::make('qwe123'),
        ]);

        $this->command->info('User seeded successfully.');
    }
}
