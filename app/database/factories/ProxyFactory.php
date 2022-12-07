<?php

namespace Database\Factories;

use App\Models\Proxy;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProxyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip' => $this->faker->ipv4(),
            'port' => $this->faker->numberBetween(10, 65000),
            'login' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'status' => $this->faker->randomElement(Proxy::STATUSES),
        ];
    }
}
