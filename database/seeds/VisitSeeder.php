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
        for($i = 0; $i < 4500; $i++){
            $newVisit = new Visit();
            $newVisit->visitor_ip = $faker->ipv4();
            $newVisit->stay_id = $faker->numberBetween(1, 2);;
            $newVisit->created_at = $faker->dateTimeBetween('-220 week', '-1 week');
            $newVisit->updated_at = $faker->dateTimeBetween('-220 week', '-1 week');
            $newVisit->save();
        }
    }
}
