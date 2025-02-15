<?php

namespace Database\Seeders;

use App\Models\Home;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $tomtomApiKey;
    public function __construct()
    {
        // chiave API di TOMTOM
        $this->tomtomApiKey = env('TOMTOM_API_KEY');
    }

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Home::truncate();

        $apartments = config('apartments');

        $client = new Client();

        foreach ($apartments as $new_apartment) {
            $apartment = new Home();

            $apartment->user_id = $new_apartment['id'];
            $apartment->title = $new_apartment['title'];
            $apartment->slug = Str::of($new_apartment['title'])->slug('-');
            $apartment->description = $new_apartment['description'];
            $apartment->beds = $new_apartment['beds'];
            $apartment->bathrooms = $new_apartment['bathrooms'];
            $apartment->rooms = $new_apartment['rooms'];
            $apartment->square_metres = $new_apartment['mq'];
            $apartment->address = $new_apartment['address'];
            $apartment->image = $new_apartment['image'];

            $response = $client->get('https://api.tomtom.com/search/2/geocode/' . urlencode($new_apartment['address']) . '.json', [
                'query' => [
                    'key' => $this->tomtomApiKey
                ],
                'verify' => false, 
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['results'][0])) {
                $apartment->lat = $data['results'][0]['position']['lat'];
                $apartment->long = $data['results'][0]['position']['lon'];
            }
            $apartment->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
