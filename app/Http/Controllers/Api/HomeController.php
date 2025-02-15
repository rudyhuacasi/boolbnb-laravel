<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Home;
use App\Models\Message;
use App\Mail\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreMessageRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        // Recuperiamo tutte le case con la relazione ads
        $homes = Home::with('ads', 'services', 'user')->get();

        $now = Carbon::now();


        $sponsoredHomes = $homes->filter(function ($home) use ($now) {
            foreach ($home->ads as $ad) {
                $startDate = $ad->pivot->created_at;
                $endDate = Carbon::parse($startDate)->addHours((int) explode(':', $ad->duration)[0]);
                if ($now->lessThan($endDate)) {
                    $home->active = 1;
                    return true;
                }
            }
            $home->active = 0;
            return false;
        });

        $nonSponsoredHomes = $homes->filter(function ($home) use ($now) {
            foreach ($home->ads as $ad) {
                $startDate = $ad->pivot->created_at;
                $endDate = Carbon::parse($startDate)->addHours((int) explode(':', $ad->duration)[0]);
                if ($now->lessThan($endDate)) {
                    return false; 
                }
            }
            $home->active = 0; 
            return true;
        });

        $allHomes = $sponsoredHomes->merge($nonSponsoredHomes);

        $perPage = 12;
        $currentPage = request()->get('page', 1);
        $paginatedHomes = $allHomes->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return response()->json([
            'status' => 'success',
            'results' => [
                'data' => $paginatedHomes,
                'total' => $allHomes->count(),
                'current_page' => $currentPage,
                'per_page' => $perPage,
            ]
        ]);

}

    public function show(String $slug)
    {
        //? dettaglio con relazione services:
        $homes = Home::where('slug', $slug)->with('services', 'user', 'messages')->first();

        if ($homes) {
            return response()->json([
                'status' => 'success',
                'results' => $homes
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'results' => null
            ], 404);
        }
    }

    public function storeMessage(StoreMessageRequest $request, $slug)
    {
        try {
            //? trova l'appartamento associato allo slug:
            $home = Home::where('slug', $slug)->first();

            if (!$home) {
                return response()->json(['status' => 'failed', 'message' => 'Appartamento non trovato'], 404);
            }

            $data = $request->validated();

            $message = new Message();

            $message->home_id = $home->id;

            $message->name = $data['name'];
            $message->email = $data['email'];
            $message->content = $data['content'];
            $message->home_id = $home->id;

            $message->save();

            //? invio email:
            Mail::to($data['email'])->send(new NewMessage($message));

            return response()->json([
                'status' => 'success',
                'message' => 'Messaggio inviato con successo!'
            ], 201);
        } catch (ValidationException $e) {
            //? erori di validazione:
            return response()->json([
                'status' => 'failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            //? gestione altri errori:
            return response()->json([
                'status' => 'failed',
                'message' => 'Si è verificato un errore durante l\'invio del messaggio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function sponsorship()
    {
        $homes = Home::with('ads', 'services', 'user')->get();
        // Comprobamos si hay datos
        if ($homes->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'results' => null,
                'message' => 'No hay casas disponibles'
            ], 404);
        }
        $now = Carbon::now();
        $sponsoredHomes = $homes->filter(function ($home) use ($now) {
            foreach ($home->ads as $ad) {
                $startDate = $ad->pivot->created_at;
                $endDate = Carbon::parse($startDate)->addHours((int) explode(':', $ad->duration)[0]);
                if ($now->lessThan($endDate)) {
                    return true; 
                }
            }
            return false; 
        });
        if ($sponsoredHomes->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'results' => null,
                'message' => 'No hay casas patrocinadas activas'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'results' => $sponsoredHomes->values()
        ]);
    }
}



