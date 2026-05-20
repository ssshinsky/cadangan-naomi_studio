<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpenClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OpenClassController extends Controller
{
    public function index()
    {
        $classes = OpenClass::latest()->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $mentors = \App\Models\Mentor::orderBy('name')->get();
        return view('admin.classes.create', compact('mentors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'mentor_id'       => ['required', 'exists:mentors,id'],
            'description'     => ['nullable', 'string'],
            'price'           => ['required', 'integer', 'min:0'],
            'song_title'      => ['nullable', 'string', 'max:255'],
            'whatsapp_link'   => ['required', 'string'],
            'day_of_week'     => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'time_start'      => ['required'],
            'time_end'        => ['required'],
            'thumbnail'       => ['nullable', 'image', 'max:2048'],
        ]);

        $admin = auth()->user()->admin;
        $mentor = \App\Models\Mentor::find($request->mentor_id);
        
        $data  = [
            'created_by'      => $admin->id,
            'title'           => $request->title,
            'slug'            => Str::slug($request->title) . '-' . time(),
            'instructor_name' => $mentor->name,
            'description'     => $request->description,
            'price'           => $request->price,
            'song_title'      => $request->song_title,
            'whatsapp_link'   => 'https://wa.me/' . ltrim($request->whatsapp_link, '/'),
            'day_of_week'     => $request->day_of_week,
            'time_start'      => $request->time_start,
            'time_end'        => $request->time_end,
            'is_active'       => $request->boolean('is_active'),
            'mentor_id'       => $request->mentor_id,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('classes', 'public');
        }

        OpenClass::create($data);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(OpenClass $class)
    {
        $mentors = \App\Models\Mentor::orderBy('name')->get();
        return view('admin.classes.edit', compact('class', 'mentors'));
    }

    public function update(Request $request, OpenClass $class)
    {
        $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'mentor_id'       => ['required', 'exists:mentors,id'],
            'description'     => ['nullable', 'string'],
            'price'           => ['required', 'integer', 'min:0'],
            'song_title'      => ['nullable', 'string', 'max:255'],
            'whatsapp_link'   => ['required', 'string'],
            'day_of_week'     => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'time_start'      => ['required'],
            'time_end'        => ['required'],
            'thumbnail'       => ['nullable', 'image', 'max:2048'],
        ]);

        $mentor = \App\Models\Mentor::find($request->mentor_id);

        $data = [
            'title'           => $request->title,
            'slug'            => Str::slug($request->title),
            'instructor_name' => $mentor->name,
            'description'     => $request->description,
            'price'           => $request->price,
            'song_title'      => $request->song_title,
            'whatsapp_link'   => 'https://wa.me/' . ltrim($request->whatsapp_link, '/'),
            'day_of_week'     => $request->day_of_week,
            'time_start'      => $request->time_start,
            'time_end'        => $request->time_end,
            'is_active'       => $request->boolean('is_active'),
            'mentor_id'       => $request->mentor_id,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($class->thumbnail) {
                Storage::disk('public')->delete($class->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('classes', 'public');
        }

        $class->update($data);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(OpenClass $class)
    {
        if ($class->thumbnail) {
            Storage::disk('public')->delete($class->thumbnail);
        }
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function toggleActive(OpenClass $class)
    {
        $class->update(['is_active' => !$class->is_active]);
        $status = $class->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Kelas \"{$class->title}\" berhasil {$status}.");
    }
}
