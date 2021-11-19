<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Flats;
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
        Model::unguard();

        $this->call(AreaTableSeeder::class);
        $this->call(FlatsTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(CompanyTableSeeder::class);

        Model::reguard();
    }
}
