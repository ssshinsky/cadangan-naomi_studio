<?php

namespace App\Http\Controllers;

use App\Models\OpenClass;

class OpenClassController extends Controller
{
    public function index()
    {
        $classes = OpenClass::where('is_active', true)->get();
        return view('open-class.index', compact('classes'));
    }

    public function show(string $slug)
    {
        $class = OpenClass::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('open-class.show', compact('class'));
    }
}
