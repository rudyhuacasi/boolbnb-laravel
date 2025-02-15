<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Home;
use Carbon\Carbon;
use App\Models\Ad;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Exception;

class PaymentController extends Controller
{
    //* Visualizza il form di pagamento con i dettagli della casa
    public function showPaymentForm($slug)
    {
        //? Trova la casa in base allo slug
        $home = Home::where('slug', $slug)->first();
        if (!$home) {
            return redirect()->back()->withErrors(['error' => 'Casa non trovata']);
        }

        //? Passa l'oggetto "home" alla vista del form di pagamento
        return view('admin.payments.form', compact('home'));
    }


    public function checkSponsorshipStatus(Home $home)
    {
        $now = Carbon::now();

        foreach ($home->ads as $ad) {
            $startDate = $ad->pivot->created_at; // Usa created_at come data di inizio
            $endDate = Carbon::parse($startDate)->addHours($ad->duration); // Aggiungi la durata

            if ($now->greaterThanOrEqualTo($endDate)) {
                // Sponsorizzazione scaduta
                echo "La sponsorizzazione per {$home->title} è scaduta.";
            } else {
                // Sponsorizzazione ancora attiva
                echo "La sponsorizzazione per {$home->title} è ancora attiva.";
            }
        }
    }


    public function storeAds(Request $request)
    {
        $adId = $request->input('sponsorship');
        $slug = $request->input('home_slug');
        // dd($slug);

        $home = Home::where('slug', $slug)->first();

        // if (!$home) {
        //     return redirect()->back()->withErrors(['error' => 'Casa non trovata']);
        // }

        //? salva il dato nella pivot:
        $home->ads()->attach($adId);
        //? Pagamento completato con successo
        return redirect()->route('admin.homes.show', $home->slug)
                     ->with('success', 'Pagamento completato con successo! Sponsorizzazione attivata.');

    }

    // public function generateToken()
    // {
    //     try {
    //         $client = new \GuzzleHttp\Client();

    //         // Esegui la richiesta HTTP POST
    //         $response = $client->post('https://api.sandbox.braintreegateway.com/merchants/' . env('BRAINTREE_MERCHANT_ID') . '/client_token', [
    //             'auth' => [env('BRAINTREE_PUBLIC_KEY'), env('BRAINTREE_PRIVATE_KEY')],
    //             'headers' => [
    //                 'Content-Type' => 'application/json',
    //                 'Accept' => 'application/json'
    //             ]
    //         ]);

    //         // Decodifica la risposta JSON
    //         $body = json_decode($response->getBody());

    //         return response()->json(['token' => $body->clientToken]);

    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Errore nella generazione del token: ' . $e->getMessage()], 500);
    //     }
    // }

    // //* Processa il pagamento
    // public function processPayment(Request $request)
    // {
    //     $amount = $request->input('amount'); // importo della sponsorizzazione
    //     $nonce = $request->input('payment_method_nonce'); // nonce di Braintree
    //     $slug = $request->input('home_slug'); // slug della casa per cui si compra la visibilità
    //     $adId = $request->input('sponsorship');

    //     $client = new Client();

    //     //? Trova la casa in base allo slug
    //     $home = Home::where('slug', $slug)->first();
    //     if (!$home) {
    //         return response()->json(['success' => false, 'message' => 'Casa non trovata']);
    //     }

    //     //? Invia la richiesta per processare il pagamento a Braintree
    //     $response = $client->post('https://api.sandbox.braintreegateway.com/merchants/' . env('BRAINTREE_MERCHANT_ID') . '/transactions', [
    //         'auth' => [env('BRAINTREE_PUBLIC_KEY'), env('BRAINTREE_PRIVATE_KEY')],
    //         'json' => [
    //             'amount' => $amount,
    //             'paymentMethodNonce' => $nonce,
    //             'options' => [
    //                 'submitForSettlement' => true
    //             ]
    //         ]
    //     ]);

    //     $body = json_decode($response->getBody());

    //     if ($body->success) {

    //         //? salva il dato nella pivot:
    //         $home->ads()->attach($adId);
    //         //? Pagamento completato con successo
    //         return redirect()->route('admin.homes.show', $home->slug)
    //                      ->with('success', 'Pagamento completato con successo! Sponsorizzazione attivata.');
    //     } else {
    //         //? Errore nel pagamento
    //         return response()->json(['success' => false, 'message' => $body->message]);
    //     }

        
    // }
}