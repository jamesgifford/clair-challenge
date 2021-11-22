<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PayItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'business_id' => 1,
            'external_id' => $this->faker->regexify('[a-z0-9]{10}'),
            'amount' => $this->faker->randomFloat(2, 1, 99999999),
            'pay_rate' => $this->faker->randomFloat(2, 1, 99999999),
            'hours' => $this->faker->randomFloat(2, 1, 999999),
            'paid_at' => $this->faker->dateTimeBetween('-5 years')->format('Y-m-d'),
        ];
    }
}
