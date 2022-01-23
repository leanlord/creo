<?php

namespace Database\Factories;

use App\Models\Flat;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Flat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'city_id' => 1,
            'square' => $this->faker->numberBetween(40, 150),
            'company_id' => $this->faker->numberBetween(1, 10),
            'area_id' => $this->faker->numberBetween(1, 10),
            'is_rented' => $this->faker->boolean,
            'price' => $this->faker->numberBetween(2500000, 10000000),
        ];
    }
}
