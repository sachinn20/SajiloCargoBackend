<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\PricingSetting;
use Illuminate\Support\Facades\Response;



class AdminController extends Controller
{

    
    public function dashboard()
{
    $totalUsers = User::where('role', '!=', 'admin')->count();
    $totalBookings = Booking::count();
    $totalVehicles = Vehicle::count();

    // Bookings Over Time Chart Data (Monthly)
    $bookingData = Booking::selectRaw("DATE_FORMAT(created_at, '%b') as month, COUNT(*) as count")
        ->groupBy('month')
        ->orderByRaw("STR_TO_DATE(month, '%b')")
        ->get();

    $bookingMonths = $bookingData->pluck('month');
    $bookingCounts = $bookingData->pluck('count');

    // Vehicle Usage Chart Data by Type
    $vehicleTypes = Vehicle::select('type')->distinct()->pluck('type');
    $vehicleTypeCounts = Vehicle::select('type', \DB::raw('count(*) as count'))
        ->groupBy('type')->pluck('count');

    return view('admin.dashboard', compact(
        'totalUsers',
        'totalBookings',
        'totalVehicles',
        'bookingMonths',
        'bookingCounts',
        'vehicleTypes',
        'vehicleTypeCounts'
    ));
}

    

    // =======================
    // USER MANAGEMENT
    // =======================

    public function users(Request $request)
    {
        $users = User::where('role', '!=', 'admin')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('admin.pages.user', compact('users'));
    }
    
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    // =======================
    // VEHICLE MANAGEMENT
    // =======================
    public function vehicles(Request $request)
    {
        $vehicles = Vehicle::with('owner')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('owner', fn($q) =>
                    $q->where('name', 'like', "%{$search}%"))
                    ->orWhere('plate', 'like', "%{$search}%");
            })
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('admin.pages.vehicle', compact('vehicles'));
    }
    

    // =======================
    // TRIPS MANAGEMENT
    // =======================

    public function trips(Request $request)
    {
        $trips = Trip::query()
            ->when($request->search, fn($q) =>
                $q->where('from_location', 'like', "%{$request->search}%")
                  ->orWhere('to_location', 'like', "%{$request->search}%"))
            ->when($request->type, fn($q) =>
                $q->where('shipment_type', $request->type))
            ->orderBy('date', 'desc')
            ->paginate(10);
    
        return view('admin.pages.trip', compact('trips'));
    }
    

    // =======================
    // BOOKINGS MANAGEMENT
    // =======================

    public function bookings(Request $request)
    {
        $query = Booking::query();
    
        // Optional filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
    
        if ($request->has('payment_mode') && $request->payment_mode !== 'all') {
            $query->where('payment_mode', $request->payment_mode);
        }
    
        if ($request->has('search') && $request->search !== '') {
            $query->where('tracking_no', 'LIKE', '%' . $request->search . '%');
        }
    
        $bookings = $query->latest()->get();
    
        return view('admin.pages.booking', compact('bookings'));
    }
    

    // =======================
    // PAYMENTS MANAGEMENT
    // =======================

  public function payments(Request $request)
{
    $query = Booking::with('user');

    // Apply filters
    if ($request->filled('search')) {
        $query->where('tracking_no', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('payment_status')) {
        $query->where('is_paid', $request->payment_status);
    }

    if ($request->filled('payment_mode')) {
        $query->where('payment_mode', $request->payment_mode);
    }

    // Clone query to calculate stats
    $statsQuery = clone $query;
    $paidCount = (clone $statsQuery)->where('is_paid', true)->count();
    $unpaidCount = (clone $statsQuery)->where('is_paid', false)->count();
    $totalAmount = (clone $statsQuery)->sum('amount');

    // Get paginated filtered bookings
    $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

    // Pricing config
    $pricing = PricingSetting::first();

    return view('admin.pages.payment', compact(
        'bookings',
        'pricing',
        'paidCount',
        'unpaidCount',
        'totalAmount'
    ));
}



public function updatePricing(Request $request)
{
    $request->validate([
        'price_per_km' => 'required|numeric|min:0',
        'price_per_kg' => 'required|numeric|min:0',
    ]);

    $pricing = PricingSetting::first();

    if (!$pricing) {
        $pricing = new PricingSetting();
    }

    $pricing->price_per_km = $request->price_per_km;
    $pricing->price_per_kg = $request->price_per_kg;
    $pricing->save();

    return back()->with('success', 'Pricing updated successfully.');
}


}
