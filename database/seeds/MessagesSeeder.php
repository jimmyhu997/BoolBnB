<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Message;


class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 500; $i++){
            $newMessage = new Message();
            $newMessage->name = $faker->ipv4();
            $newMessage->content = $faker->paragraph(8);
            $newMessage->email = $faker->email();
            $newMessage->stay_id = $faker->numberBetween(1, 2);;
            $newMessage->created_at = $faker->dateTimeBetween('-120 week', '-1 week');
            $newMessage->updated_at = $faker->dateTimeBetween('-120 week', '-1 week');
            $newMessage->save();
        }
    }
}
