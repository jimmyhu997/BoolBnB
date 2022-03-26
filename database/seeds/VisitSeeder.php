<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Visit;
use App\Stay;
use Illuminate\Support\Facades\Auth;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $stayIds = Stay::select('id')->get()->toArray();
        
        for($i = 0; $i < 4500; $i++){

            $arr_rand = array_rand($stayIds);

            $newVisit = new Visit();
            $newVisit->visitor_ip = $faker->ipv4();
            $newVisit->stay_id = $stayIds[$arr_rand]['id'];
            $newVisit->created_at = $faker->dateTimeBetween('-220 week', '-1 week');
            $newVisit->updated_at = $faker->dateTimeBetween('-220 week', '-1 week');
            $newVisit->save();
        }
    }
}
