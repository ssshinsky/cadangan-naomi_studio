<?php

namespace App\Http\Controllers;

use App\Models\Studio;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with(['facilities', 'images'])->where('is_available', true)->where('is_active', true)->get();
        return view('studios.index', compact('studios'));
    }

    public function show(string $slug)
    {
        $studio = Studio::with(['facilities', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $reviews   = $studio->reviews()->with('customer')->where('is_visible', true)->latest()->get();
        $avgRating = $studio->reviews()->where('is_visible', true)->avg('rating');

        return view('studios.show', compact('studio', 'reviews', 'avgRating'));
    }
}
