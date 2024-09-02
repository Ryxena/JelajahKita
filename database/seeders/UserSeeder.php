<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@mail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@mail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@mail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@mail.com',
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
