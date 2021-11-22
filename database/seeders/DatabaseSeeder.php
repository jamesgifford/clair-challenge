<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        \App\Models\User::factory(20)->create()->each(function ($user) use ($faker) {
            $businesses = \App\Models\Business::factory(5)->create()->each(function ($business) use ($user, $faker) {
                \App\Models\PayItem::factory(20)->create([
                    'user_id' => $user->id,
                    'business_id' => $business->id,
                ]);
            });

            foreach ($businesses as $business) {
                $user->businesses()->attach($business->id, ['external_id' => $faker->regexify('[a-z0-9]{10}')]);
            }
        });
    }
}
