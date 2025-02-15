<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class GeocodingController extends Controller
{
    //? passiamo il dato come stringa:
    public function getCoordinates(string $address)
    {
        if (!$address) {
            return ['error' => 'Indirizzo non fornito'];
        }

        //? Costruiamo l'URL per chiamare l'API TomTom:
        $apiKey = env('TOMTOM_API_KEY');
        $url = "https://api.tomtom.com/search/2/geocode/" . urlencode($address) . ".json";

        //? richiesta API:
        $response = Http::withOptions([
            //? Disabilita la verifica del certificato SSL:
            'verify' => false, 
        ])->get($url, ['key' => $apiKey,]);

        //? gestiamo la rispasta:
        if ($response->successful()) {
            $data = $response->json();

            //? se c'è una risposta positiva restituisce un risultao:
            if (isset($data['results'][0]['position'])) {
                //? risultato -> latitudine e longitudine:
                return $data['results'][0]['position'];
            } else {
                return ['error' => 'Coordinate non trovate'];
            }
        }

        return ['error' => 'Errore nella chiamata API'];
    }
}
