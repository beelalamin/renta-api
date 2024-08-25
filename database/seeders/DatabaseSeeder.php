<?php

namespace Database\Seeders;

 
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the Brand table
        Brand::factory(10)->create();

        // Seed the Category table
        Category::factory(10)->create();

        
        // Seed the Vehicle table
        Vehicle::factory(50)->create();
    }
}
