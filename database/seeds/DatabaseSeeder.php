<?php

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
             AccountTypesSeeder::class,
             UsersSeeder::class,
             RegionsSeeder::class,
             TourTypesSeeder::class,
             FiltersSeeder::class,
             TicketsSeeder::class,
             ReservationStatusesSeeder::class,
             PropertyTypesSeeder::class,
             PropertyParamsSeeder::class
         ]);
    }
}
