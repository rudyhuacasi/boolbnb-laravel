<?php

namespace Database\Seeders;

use App\Models\Home;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //? disabilito relazioni:
        Schema::disableForeignKeyConstraints();

        //? ripulisco tabella:
        Message::truncate();

        //? popolo random la tabella:
        for ($i = 0; $i < 120; $i++) {
            
            $new_message = new Message();

            $new_message->home_id = Home::inRandomOrder()->first()->id;
            $new_message->name = fake()->name();
            $new_message->email = fake()->email();
            $new_message->content = fake()->text(200);

            $new_message->save();

        }


    
        //? riabilito relazioni:
        Schema::enableForeignKeyConstraints();




    }
    
}


