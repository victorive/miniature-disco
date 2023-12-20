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
        $user = User::query()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('Password1234#')
        ]);

        $user->assignRole('User');
    }
}
