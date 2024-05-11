<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'John Doe',
            'Jane Smith',
            'Michael Johnson',
            'Emily Brown',
            'David Lee',
            'Sarah Wilson',
            'Robert Taylor',
            'Olivia Martinez',
            'James Anderson',
            'Emma Thomas',
            'William Garcia',
            'Sophia Hernandez',
            'Matthew Young',
            'Isabella Lopez',
            'Daniel Scott',
            'Mia King',
            'Christopher Hall',
            'Ava Allen',
            'Joseph Green',
            'Ella Adams'
        ];

        foreach ($names as $name) {
            User::create([
                'name' => $name,
                'email' => Str::slug($name) . '@example.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
