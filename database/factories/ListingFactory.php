<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'user_id' => $this->faker->numberBetween(1, 10),
            'tags' => $this->faker->word(),
            'company' => $this->faker->company(),
            'location' => $this->faker->city(),
            'email' => $this->faker->email(),
            'website' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
