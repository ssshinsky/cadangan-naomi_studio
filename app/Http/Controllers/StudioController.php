<?php

namespace App\Http\Controllers;

use App\Models\Studio;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with(['facilities', 'images'])->where('is_available', true)->get();
        return view('studios.index', compact('studios'));
    }

    public function show(string $slug)
    {
        $studio = Studio::with(['facilities', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('studios.show', compact('studio'));
    }
}
