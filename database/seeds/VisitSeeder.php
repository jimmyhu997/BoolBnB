<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Visit;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 5; $i++){
            $newVisit = new Visit();
            $newVisit->visitor_ip = $faker->ipv4();
            $newVisit->stay_id = $faker->numberBetween(1, 7);;
            // $newVisit->created_at = $faker->date() ;
            // $newVisit->updated_at = $faker->date() ;
            $newVisit->save();
        }
    }
}
