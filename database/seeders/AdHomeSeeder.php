<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\AdHome;
use App\Models\Home;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdHomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        //? disabilito relazioni:
        Schema::disableForeignKeyConstraints();

        //? ripulisco tabella:
        AdHome::truncate();

        //? popoliamo random la tabella pivot:
        for ($i = 0; $i < 120; $i++) {
            $ad_home = new AdHome();

            $ad_home->ad_id = Ad::inRandomOrder()->first()->id;
            $ad_home->home_id = Home::inRandomOrder()->first()->id;

            $ad_home->save();

        }

        //? abilito relazione:
        Schema::enableForeignKeyConstraints();


    }
}
