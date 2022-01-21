<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Flat;
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
        $this->call([
           AreaSeeder::class,
           CompanySeeder::class,
           CitySeeder::class,
           FlatSeeder::class,
        ]);
    }
}
