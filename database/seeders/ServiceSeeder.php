<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Service::truncate();

        $service = config('service');

        foreach ($service as $new_service) {
            $service = new Service();

            $service->name = $new_service['name'];
            $service->icon = $new_service['icon'];
            
            $service->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
