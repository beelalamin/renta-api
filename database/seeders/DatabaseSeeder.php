<?php

namespace Database\Seeders;


use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Vehicle;
use App\Models\Shop\Booking;
use App\Models\Shop\Payment;
use App\Models\System\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(10)->create();
        // Brand::factory(5)->create();
        Category::factory(8)->create();
        Vehicle::factory(30)->create();

    }
}
