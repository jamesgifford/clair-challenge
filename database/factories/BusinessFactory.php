<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'external_id' => $this->faker->regexify('[a-z0-9]{10}'),
            'name' => $this->faker->company(),
            'enabled' => $this->faker->boolean(80),
            'deduction' => $this->faker->numberBetween(0, 100),
        ];
    }
}
