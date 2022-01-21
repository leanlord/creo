<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\City;
use App\Models\Company;
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
            'city_id' => $this->faker->numberBetween(City::first()->id, City::latest('id')->first()->id),
            'square' => $this->faker->numberBetween(40, 150),
            'company_id' => $this->faker->numberBetween(Company::first()->id, Company::latest('id')->first()->id),
            'area_id' => $this->faker->numberBetween(Area::first()->id, Area::latest('id')->first()->id),
            'is_rented' => $this->faker->boolean(),
            'price' => $this->faker->numberBetween(2500000, 10000000),
        ];
    }
}
