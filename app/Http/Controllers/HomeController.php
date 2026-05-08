<?php

namespace App\Http\Controllers;

use App\Models\OpenClass;
use App\Models\Studio;

class HomeController extends Controller
{
    public function index()
    {
        $openClasses = OpenClass::where('is_active', true)->take(3)->get();
        $studios     = Studio::where('is_available', true)->with(['primaryImage', 'facilities'])->get();

        return view('home', compact('openClasses', 'studios'));
    }
}
