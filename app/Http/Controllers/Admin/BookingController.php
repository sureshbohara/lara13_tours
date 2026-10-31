<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
      
    }

    public function index(Request $request){
        $filters = $request->only('status', 'search');
        
        $query = Booking::with(['package', 'fixedDeparture'])->latest();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15);
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'filters' => $filters,
            'statuses' => $statuses,
        ]);
    }

    public function show(Booking $booking){
        $booking->load(['package', 'fixedDeparture']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking): JsonResponse
    {
        $request->validate([
             'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully!'
        ]);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->back()->with('success', 'Booking deleted permanently!');
    }
}