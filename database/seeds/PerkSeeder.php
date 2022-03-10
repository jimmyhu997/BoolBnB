<?php

use App\Perk;
use Illuminate\Database\Seeder;

class PerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perks = json_decode(file_get_contents(storage_path() . '/data/perks.json'));
        foreach($perks->perks as $perk){
            $newPerk = new Perk();
            $newPerk->name = $perk;
            $newPerk->save();
        }
    }
}
