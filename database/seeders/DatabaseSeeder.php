<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Rate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed a default admin/test user
        User::updateOrCreate(
            ['email' => 'admin@pianupecave.test'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Seed Pian Upe Cave House property
        $property = Property::firstOrCreate(
            ['slug' => 'pian-upe-cave-house'],
            [
                'name' => 'Pian Upe Cave House',
                'description' => 'A private eco-luxury cave house in Pian Upe Game Reserve, Eastern Uganda.',
                'max_rooms' => 3,
                'base_currency' => 'USD',
                'min_nights' => 1,
                'max_nights' => null,
                'default_rate_per_person' => 220,
                'default_rate_per_couple' => 330,
                'capacity_per_room' => 2,
                'settings' => [
                    'location' => 'Pian Upe Game Reserve, Eastern Uganda',
                    'coordinates' => '3°4742.783 33°515.083',
                    'phone' => '+256 (0) 761 311 772',
                    'whatsapp' => '+256 777 643084',
                    'email' => 'reservations@pianupecave.com',
                ],
            ]
        );

        // Seed a base year-round rate
        Rate::firstOrCreate(
            [
                'property_id' => $property->id,
                'season_name' => 'Standard Rate',
            ],
            [
                'starts_at' => now()->startOfYear(),
                'ends_at' => now()->endOfYear(),
                'rate_per_person' => 220,
                'rate_per_couple' => 330,
                'extra_person_rate' => 220,
                'min_nights' => 1,
                'max_nights' => null,
                'is_active' => true,
            ]
        );
    }
}
