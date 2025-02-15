<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeoAutoSearchController extends Controller
{
    public function getAddressSuggestions(Request $request)
    {
        //? prende la query dall'input:
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['error' => 'Nessuna query fornita'], 400);
        }

        //? chiamata API TomTom:
        $apiKey = env('TOMTOM_API_KEY');
        $url = "https://api.tomtom.com/search/2/search/" . urlencode($query) . ".json";

        $response = Http::withOptions([
            //? Disabilita la verifica del certificato SSL:
            'verify' => false
            ])->get($url, [
            'key' => $apiKey,
            'typeahead' => 'true',
            'limit' => 5
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $suggestions = [];

            //? estraiamo i suggerimenti dall'API:
            foreach ($data['results'] as $result) {
                $suggestions[] = $result['address']['freeformAddress'];
            }

            return response()->json($suggestions);
        }

        return response()->json(['error' => 'Errore nella chiamata all\'API TomTom'], 500);
    }
}
