<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Trip;
use App\Models\Booking;



class AdminController extends Controller
{

    
    public function dashboard()
    {
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalBookings = Booking::count();
        $totalVehicles = Vehicle::count();
    
        return view('admin.dashboard', compact('totalUsers', 'totalBookings', 'totalVehicles'));
    }
    

    // =======================
    // USER MANAGEMENT
    // =======================

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->get();
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

    public function vehicles()
    {
        $vehicles = Vehicle::with('owner')->get(); // assumes each vehicle has a user_id
        return view('admin.pages.vehicle', compact('vehicles'));
    }

    // =======================
    // TRIPS MANAGEMENT
    // =======================

    public function trips()
    {
        $trips = Trip::all();
        return view('admin.pages.trip', compact('trips'));
    }

    // =======================
    // BOOKINGS MANAGEMENT
    // =======================

    public function bookings()
    {
        $bookings = Booking::all();
        return view('admin.pages.booking', compact('bookings'));
    }

    // =======================
    // PAYMENTS MANAGEMENT
    // =======================

    public function payments()
    {
        return view('admin.pages.payment'); // static for now
    }
}
