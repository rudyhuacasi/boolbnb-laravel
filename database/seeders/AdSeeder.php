<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $ads = config('ads');

        foreach ($ads as $new_ad) {
            $ad = new Ad();

            $ad->id = $new_ad['id'];
            $ad->title = $new_ad['title'];
            $ad->duration = $new_ad['duration'];
            $ad->price = $new_ad['price'];

            $ad->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
