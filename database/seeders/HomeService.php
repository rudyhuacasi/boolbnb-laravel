<?php

namespace Database\Seeders;

use App\Models\Home;
use App\Models\HomeService as ModelsHomeService;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HomeService extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //? disabilito relazioni:
        Schema::disableForeignKeyConstraints();

        //? ripulisco tabella:
        ModelsHomeService::truncate();

        //? popoliamo random la tabella pivot:
        for ($i = 0; $i < 120; $i++) {
            $home_service = new ModelsHomeService();

            $home_service->home_id = Home::inRandomOrder()->first()->id;
            $home_service->service_id = Service::inRandomOrder()->first()->id;

            $home_service->save();
        }

        //? abilito relazione:
        Schema::enableForeignKeyConstraints();
    }
}
