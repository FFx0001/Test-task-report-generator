<?php

namespace Database\Seeders;

use App\Models\SoldCar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class SoldCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 30; $i++) {
            $sold_car = new SoldCar;
            $sold_car->brand = $faker->randomElement(["Acura","Audi","Bentley","BMW","Bugatti","Cadilac"]);
            $sold_car->model = $faker->randomElement(["Acura","Audi","Bentley","BMW","Bugatti","Cadilac"]);
            $sold_car->vin = "0FFFF00FFFF000000";
            $sold_car->engine_capacity = $faker->randomFloat(100,1000);
            $sold_car->engine_power =$faker->randomFloat(100,1000);
            $sold_car->type_of_kpp = $faker->randomElement(['AKPP','CVT','DSG','MKPP']);
            $sold_car->year_of_release = $faker->year;
            $sold_car->date_of_sale = $faker->dateTime;
            $sold_car->dealer = $faker->randomElement(["Адванс-Авто","ААРОН АВТО","Великан","Германика","Автотрейд АГ","Favorit Motors","Автодом","АвтоПассаж"]);
            $sold_car->save();
        }
    }
}
