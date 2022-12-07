<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(),
            'code' => $this->faker->word(),
            'url' => $this->faker->url(),
            'status' => $this->faker->randomElement(Provider::STATUSES),
            'user_id' => 1,
        ];
    }
}
