<?php

use App\SponsorPackage;
use Illuminate\Database\Seeder;

class SponsorPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [
            [
                "name"=>"Tier 1",
                "price"=>2.99,
                "duration"=>24
            ],
            [
                "name"=>"Tier 2",
                "price"=>5.99,
                "duration"=>72
            ],
            [
                "name"=>"Tier 3",
                "price"=>9.99,
                "duration"=>144
            ],
        ];
        foreach($sponsors as $sponsor){
            $newSponsor = new SponsorPackage();
            $newSponsor->name = $sponsor["name"];
            $newSponsor->price = $sponsor["price"];
            $newSponsor->duration = $sponsor["duration"];
            $newSponsor->save();
        }    
    }
}
