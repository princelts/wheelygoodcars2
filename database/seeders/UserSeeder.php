<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '+1234567890', // Example phone number
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $faker = Faker::create();
        
        foreach (range(1, 149) as $index) {
            $createdAt = Carbon::createFromTimestamp(rand(
                strtotime('2024-01-01'),
                strtotime('today')
            ));

            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'phone_number' => $faker->phoneNumber,
                'is_admin' => false,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
