<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeRequest;
use App\Http\Requests\UpdateHomeRequest;
use App\Models\Home;
use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class HomeController extends Controller
{

    protected $geocodingController;

    //? Costruttore per GeocodingController:
    public function __construct(GeocodingController $geocodingController)
    {
        $this->geocodingController = $geocodingController;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $homes = Home::all();
        $userId = Auth::user()->id;

        $homes = Home::where('user_id', $userId)->get();

        return view('admin.homes.index', compact('homes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.homes.create', compact('services')); //compact('services')
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomeRequest $request)
    {
        $data = $request->validated();


        //? Indirizzo per le coordinate:
        $address = $data['address'];

        //? Richiamiamo il metodo dal GeocodingController:
        $coordinates = $this->geocodingController->getCoordinates($address);

        if (isset($coordinates['error'])) {
            //? Gestiamo l'errore, reindirizziamo l'utente con il messaggio di errore:
            return redirect()->back()->withErrors(['address' => $coordinates['error']]);
        }

        //? Risultato della chiamata API:
        $latitude = $coordinates['lat'];
        $longitude = $coordinates['lon'];



        $img_path = $request->file('image')->store('uploads');

        $apartment = new Home();
        $apartment->title = $data['title'];
        $apartment->slug = Str::of($data['title'])->slug();
        $apartment->description = $data['description'];
        $apartment->beds = $data['beds'];
        $apartment->bathrooms = $data['bathrooms'];
        $apartment->rooms = $data['rooms'];
        $apartment->square_metres = $data['square_metres'];
        $apartment->address = $data['address'];
        $apartment->lat = $latitude;
        $apartment->long = $longitude;
        $apartment->active = $data['active'];
        $apartment->user_id = Auth::user()->id;
        $apartment->image = $img_path;

        $apartment->save();
        if ($request->has('services')) {

            $apartment->services()->sync($request->services);
        } else {
            $apartment->services()->detach();
        }

        return redirect()->route('admin.homes.index')->with('message', 'creazione avvenuta con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        // $home->load('services', 'ads');

        //? Calcola il tempo rimanente per ogni sponsorizzazione attiva:
        $sponsorships = [];
        $now = Carbon::now();
        $activeSponsorship = null;

       
        foreach ($home->ads as $ad) {
            //? uso created_at come data di inizio:
            $startDate = $ad->pivot->created_at; 

            $durationInHours = (int) explode(':', $ad->duration)[0];
            
            //? durata:
            $endDate = Carbon::parse($startDate)->addHours($durationInHours); 
            
            //? se ancora attiva, calcola il tempo rimanente:

            if ($now->lessThan($endDate)) {
                $remainingTime = $endDate->diffForHumans($now);
                $sponsorships[] = [
                    'ad_id' => $ad->id,
                    'ad' => $ad->title,
                    'remaining_time' => $remainingTime,
                ];
            }
        }

        // dump("Ad Duration: ", $ad->duration);
        // dd($sponsorships);
        // Seleziona solo la prima sponsorizzazione attiva
        $activeSponsorship = collect($sponsorships)->first(function ($sponsorship) use ($home) {
            return $sponsorship['ad_id'] == $home->ads->first()->id;
        });

        


        return view('admin.homes.show', compact('home', 'activeSponsorship'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        $services = Service::all();
        return view('admin.homes.edit', compact('home', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHomeRequest $request, Home $home)
    {
        $data = $request->validated();

        //? per non sovrascrivere l'immagine in caso non venga caricata un'altra immagine:
        if ($request->hasFile('image')) {

            $img_path = Storage::put('upload', $request->file('image'));
            $data['image'] = $img_path;
        }

        //? Indirizzo per le coordinate:
        $address = $data['address'];

        //? verifichiama se l'indirizzo è stato modificato:
        if ($address !== $home->address) {
            //? Richiamiamo il metodo dal GeocodingController:
            $coordinates = $this->geocodingController->getCoordinates($address);

            //? Gestiamo l'errore, reindirizziamo l'utente con il messaggio di errore:
            if (isset($coordinates['error'])) {
                return redirect()->back()->withErrors(['address' => $coordinates['error']]);
            }

            //? risultato della chiamata API:
            $latitude = $coordinates['lat'];
            $longitude = $coordinates['lon'];
        } else {
            $latitude = $home->lat;
            $longitude = $home->long;
        }


        $home->title = $data['title'];
        $home->slug = Str::of($data['title'])->slug();
        $home->description = $data['description'];
        $home->beds = $data['beds'];
        $home->bathrooms = $data['bathrooms'];
        $home->rooms = $data['rooms'];
        $home->square_metres = $data['square_metres'];
        $home->address = $data['address'];
        $home->lat = $latitude;
        $home->long = $longitude;
        $home->active = $data['active'];
        $home->user_id = Auth::user()->id;

        $home->save();

        if ($request->has('services')) {

            $home->services()->sync($request->services);
        } else {
            $home->services()->detach();
        }

        $home->save();
        return redirect()->route('admin.homes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        $home->services()->detach();

        if ($home->image) {
            Storage::delete($home->image);
        }

        $home->delete();

        return redirect()->route('admin.homes.index');
    }
}
