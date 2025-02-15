<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Home;
use App\Models\Visual;
use Illuminate\Http\Request;

class VisualController extends Controller
{
    public function store(Request $request)
    {
        $home = Home::where('id', $request->home_id)->firstOrFail();

        $visual = new Visual();
        $visual->ip = $request->ip();
        $visual->home_id = $home->id;
        $visual->save();

        return response()->json(['message' => 'Visualizzazione registrata con successo']);
    }
}
