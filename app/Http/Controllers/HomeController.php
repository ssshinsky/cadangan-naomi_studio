<?php

namespace App\Http\Controllers;

use App\Models\OpenClass;
use App\Models\Studio;

class HomeController extends Controller
{
    public function index()
    {
        $openClasses   = OpenClass::where('is_active', true)->take(3)->get();
        $studios       = Studio::where('is_available', true)->where('is_active', true)->with(['primaryImage', 'facilities'])->get();
        $latestReviews = \App\Models\StudioReview::with(['customer', 'studio'])
            ->where('is_visible', true)
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('openClasses', 'studios', 'latestReviews'));
    }
}
