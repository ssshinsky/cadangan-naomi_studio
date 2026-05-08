<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MentorController extends Controller
{
    public function index()
    {
        $mentors = Mentor::latest()->get();
        return view('admin.mentors.index', compact('mentors'));
    }

    public function create()
    {
        return view('admin.mentors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'photo'      => ['nullable', 'image', 'max:2048'],
            'bio'        => ['nullable', 'string'],
            'experience' => ['nullable', 'string'],
            'expertise'  => ['nullable', 'string'],
        ]);

        $data = [
            'name'       => $request->name,
            'bio'        => $request->bio,
            'experience' => $request->experience,
            'expertise'  => $request->expertise,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('mentors', 'public');
        }

        Mentor::create($data);

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor berhasil ditambahkan.');
    }

    public function edit(Mentor $mentor)
    {
        return view('admin.mentors.edit', compact('mentor'));
    }

    public function update(Request $request, Mentor $mentor)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'photo'      => ['nullable', 'image', 'max:2048'],
            'bio'        => ['nullable', 'string'],
            'experience' => ['nullable', 'string'],
            'expertise'  => ['nullable', 'string'],
        ]);

        $data = [
            'name'       => $request->name,
            'bio'        => $request->bio,
            'experience' => $request->experience,
            'expertise'  => $request->expertise,
        ];

        if ($request->hasFile('photo')) {
            if ($mentor->photo) {
                Storage::disk('public')->delete($mentor->photo);
            }
            $data['photo'] = $request->file('photo')->store('mentors', 'public');
        }

        $mentor->update($data);

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor berhasil diperbarui.');
    }

    public function destroy(Mentor $mentor)
    {
        if ($mentor->photo) {
            Storage::disk('public')->delete($mentor->photo);
        }
        $mentor->delete();

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor berhasil dihapus.');
    }
}
