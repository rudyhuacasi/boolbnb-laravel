<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Home;
use App\Models\User;
use App\Models\Visual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $homes = Home::where('user_id', $user->id)->get();
        $homeIds = $homes->pluck('id'); 

        $visitors = Visual::whereIn('home_id', $homeIds)->get(); 

        return view('admin.dashboard', compact('user', 'homes', 'visitors'));
    }
}
