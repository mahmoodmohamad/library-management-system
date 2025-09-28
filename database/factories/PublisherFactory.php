<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Publisher::class;
    public function definition(): array
    {
        return [
            //
            "name"=> $this->faker->name,
            "email"=> $this->faker->safeEmail,
            "address"=> $this->faker->address,
            "postcode"=> $this->faker->postcode,
            "website"=>$this->faker->url,

        ];
    }
}
