<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\ShopInfo;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first ShopInfo ID to assign activities to
        $shopInfo = ShopInfo::first();

        if (!$shopInfo) {
            $this->command->info('No shop info found. Please create a provider with shop info first.');
            return;
        }

        $activities = [
            [
                'name' => 'Kayaking Adventure',
                'activity_type' => 'water_sports',
                'description' => 'Enjoy a beautiful day kayaking along the coast with stunning views.',
                'location' => 'Pulau Perhentian, Terengganu',
                'requirements' => 'Basic swimming ability required.',
                'min_participants' => 2,
                'max_participants' => 10,
                'duration_minutes' => 180,
                'price' => 120.00,
                'price_type' => 'per_person',
                'includes_gear' => true,
                'included_items' => 'Kayak, paddle, life jacket, basic training',
                'is_active' => true,
            ],
            [
                'name' => 'Mountain Biking Tour',
                'activity_type' => 'land_activities',
                'description' => 'Experience the thrill of mountain biking through challenging terrain.',
                'location' => 'Bukit Kiara, Kuala Lumpur',
                'requirements' => 'Good physical fitness required.',
                'min_participants' => 4,
                'max_participants' => 12,
                'duration_minutes' => 240,
                'price' => 150.00,
                'price_type' => 'per_person',
                'includes_gear' => true,
                'included_items' => 'Mountain bike, helmet, gloves, water bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Cultural Heritage Walk',
                'activity_type' => 'cultural',
                'description' => 'Explore the rich cultural heritage with a guided walking tour.',
                'location' => 'Melaka Heritage Zone',
                'requirements' => 'Comfortable walking shoes',
                'min_participants' => 5,
                'max_participants' => 15,
                'duration_minutes' => 120,
                'price' => 65.00,
                'price_type' => 'per_person',
                'includes_gear' => false,
                'included_items' => 'Tour guide, water, light refreshments',
                'is_active' => true,
            ],
            [
                'name' => 'Jungle Trekking Expedition',
                'activity_type' => 'land_activities',
                'description' => 'Trek through the lush rainforest and discover hidden waterfalls.',
                'location' => 'Taman Negara, Pahang',
                'requirements' => 'Good physical fitness, insect repellent, proper hiking boots',
                'min_participants' => 3,
                'max_participants' => 8,
                'duration_minutes' => 300,
                'price' => 180.00,
                'price_type' => 'per_person',
                'includes_gear' => false,
                'included_items' => 'Professional guide, safety equipment, packed lunch',
                'is_active' => true,
            ],
            [
                'name' => 'Sunset Yacht Cruise',
                'activity_type' => 'water_sports',
                'description' => 'Enjoy the beautiful sunset while cruising on a luxury yacht.',
                'location' => 'Port Dickson, Negeri Sembilan',
                'min_participants' => 6,
                'max_participants' => 20,
                'duration_minutes' => 180,
                'price' => 250.00,
                'price_type' => 'per_person',
                'includes_gear' => true,
                'included_items' => 'Welcome drink, light snacks, swimming opportunity',
                'is_active' => false,
            ],
        ];

        foreach ($activities as $activityData) {
            Activity::create(array_merge($activityData, ['shop_info_id' => $shopInfo->id]));
        }

        $this->command->info('Added 5 sample activities to the database.');
    }
}