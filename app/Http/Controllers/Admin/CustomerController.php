<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['user', 'bookings'])
            ->withCount('bookings');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q2) => $q2->where('email', 'like', '%' . $request->search . '%'));
            });
        }

        $customers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function toggleActive(Customer $customer)
    {
        $customer->user->update([
            'is_active' => ! $customer->user->is_active,
        ]);

        $status = $customer->user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$customer->name} berhasil {$status}.");
    }

    public function resetPassword(Request $request, Customer $customer)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $customer->user->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', "Password {$customer->name} berhasil direset.");
    }
}
