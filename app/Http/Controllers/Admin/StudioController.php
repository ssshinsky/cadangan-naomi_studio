<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\StudioFacility;
use App\Models\StudioImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with(['primaryImage', 'facilities'])->get();
        return view('admin.studios.index', compact('studios'));
    }

    public function create()
    {
        return view('admin.studios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'price_per_hour' => ['required', 'integer', 'min:1'],
            'extra_price_per_hour'  => ['nullable', 'integer'],
            'extra_price_threshold' => ['nullable', 'integer'],
            'min_dp_amount'  => ['required', 'integer', 'min:1'],
            'capacity'       => ['required', 'integer', 'min:1'],
            'size_sqm'       => ['nullable', 'string'],
            'floor_type'     => ['nullable', 'string'],
            'facilities'     => ['nullable', 'string'],
            'primary_image'  => ['nullable', 'image', 'max:5120'],
            'video'          => ['nullable', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm', 'max:102400'],
        ]);

        $admin  = auth()->user()->admin;
        $studio = Studio::create([
            'created_by'            => $admin->id,
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name) . '-' . time(),
            'description'           => $request->description,
            'rules'                 => $request->rules,
            'price_per_hour'        => $request->price_per_hour,
            'extra_price_per_hour'  => $request->extra_price_per_hour ?? 0,
            'extra_price_threshold' => $request->extra_price_threshold ?? 0,
            'min_dp_amount'         => $request->min_dp_amount,
            'capacity'              => $request->capacity,
            'size_sqm'              => $request->size_sqm,
            'floor_type'            => $request->floor_type,
            'is_available'          => $request->has('is_available'),
        ]);

        // Upload video utama
        if ($request->hasFile('video')) {
            $studio->update([
                'video' => $request->file('video')->store('studios/videos', 'public'),
            ]);
        }

        // Upload foto utama
        if ($request->hasFile('primary_image')) {
            $path = $request->file('primary_image')->store('studios', 'public');
            StudioImage::create([
                'studio_id'  => $studio->id,
                'image_url'  => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        // Upload foto tambahan
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $i => $file) {
                $path = $file->store('studios', 'public');
                StudioImage::create([
                    'studio_id'  => $studio->id,
                    'image_url'  => $path,
                    'is_primary' => false,
                    'sort_order' => $i + 1,
                ]);
            }
        }

        // Simpan fasilitas
        if ($request->facilities) {
            $items = array_filter(array_map('trim', explode(',', $request->facilities)));
            foreach ($items as $item) {
                StudioFacility::create([
                    'studio_id' => $studio->id,
                    'name'      => $item,
                ]);
            }
        }

        return redirect()->route('admin.studios.index')->with('success', 'Studio berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $studio = Studio::with(['primaryImage', 'facilities'])->findOrFail($id);
        return view('admin.studios.edit', compact('studio'));
    }

    public function update(Request $request, $id)
    {
        $studio = Studio::findOrFail($id);

        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'price_per_hour' => ['required', 'integer', 'min:1'],
            'extra_price_per_hour'  => ['nullable', 'integer'],
            'extra_price_threshold' => ['nullable', 'integer'],
            'min_dp_amount'  => ['required', 'integer', 'min:1'],
            'capacity'       => ['required', 'integer', 'min:1'],
            'size_sqm'       => ['nullable', 'string'],
            'floor_type'     => ['nullable', 'string'],
            'facilities'     => ['nullable', 'string'],
            'primary_image'  => ['nullable', 'image', 'max:5120'],
            'video'          => ['nullable', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm', 'max:102400'],
        ]);

        $studio->update([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'description'           => $request->description,
            'rules'                 => $request->rules,
            'price_per_hour'        => $request->price_per_hour,
            'extra_price_per_hour'  => $request->extra_price_per_hour ?? 0,
            'extra_price_threshold' => $request->extra_price_threshold ?? 0,
            'min_dp_amount'         => $request->min_dp_amount,
            'capacity'              => $request->capacity,
            'size_sqm'              => $request->size_sqm,
            'floor_type'            => $request->floor_type,
            'is_available'          => $request->has('is_available'),
        ]);

        // Ganti video kalau ada upload baru
        if ($request->hasFile('video')) {
            if ($studio->video) {
                Storage::disk('public')->delete($studio->video);
            }
            $studio->update([
                'video' => $request->file('video')->store('studios/videos', 'public'),
            ]);
        }

        // Hapus video jika diminta
        if ($request->has('delete_video') && $request->delete_video == '1') {
            if ($studio->video) {
                Storage::disk('public')->delete($studio->video);
            }
            $studio->update(['video' => null]);
        }

        // Ganti foto utama kalau ada upload baru
        if ($request->hasFile('primary_image')) {
            $old = $studio->primaryImage;
            if ($old) {
                Storage::disk('public')->delete($old->image_url);
                $old->delete();
            }
            $path = $request->file('primary_image')->store('studios', 'public');
            StudioImage::create([
                'studio_id'  => $studio->id,
                'image_url'  => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        // Tambah foto extra baru
        if ($request->hasFile('extra_images')) {
            $lastOrder = $studio->images()->max('sort_order') ?? 0;
            foreach ($request->file('extra_images') as $i => $file) {
                $path = $file->store('studios', 'public');
                StudioImage::create([
                    'studio_id'  => $studio->id,
                    'image_url'  => $path,
                    'is_primary' => false,
                    'sort_order' => $lastOrder + $i + 1,
                ]);
            }
        }

        // Hapus foto yang dipilih untuk dihapus
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = StudioImage::find($imageId);
                if ($img && $img->studio_id === $studio->id) {
                    Storage::disk('public')->delete($img->image_url);
                    $img->delete();
                }
            }
        }

        // Update fasilitas
        if ($request->has('facilities')) {
            $studio->facilities()->delete();
            $items = array_filter(array_map('trim', explode(',', $request->facilities)));
            foreach ($items as $item) {
                StudioFacility::create([
                    'studio_id' => $studio->id,
                    'name'      => $item,
                ]);
            }
        }

        return redirect()->route('admin.studios.index')->with('success', 'Studio berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $studio = Studio::findOrFail($id);
        // Do not delete studio; mark as inactive instead
        $studio->update(['is_active' => false]);

        return redirect()->route('admin.studios.index')->with('success', 'Studio berhasil dinonaktifkan.');
    }

    public function toggleActive($id)
    {
        $studio = Studio::findOrFail($id);
        $studio->update(['is_active' => !$studio->is_active]);
        $status = $studio->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Studio \"{$studio->name}\" berhasil {$status}.");
    }
}
