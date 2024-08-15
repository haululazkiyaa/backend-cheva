<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventRegistrationResource;

class EventRegistrationController extends Controller
{
    // API untuk melihat semua riwayat pendaftaran event
    public function index()
    {
        $registrations = EventRegistration::all();
        return EventRegistrationResource::collection($registrations);
    }

    // API untuk melihat detail riwayat pendaftaran event berdasarkan ID
    public function show($id)
    {
        $registration = EventRegistration::find($id);

        if (is_null($registration)) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        return new EventRegistrationResource($registration);
    }

    // API untuk mendaftarkan user ke event
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'registration_date' => 'required|date'
        ]);

        $registration = new EventRegistration([
            'user_id' => Auth::id(), // ID pengguna saat ini
            'event_id' => $request->event_id,
            'registration_date' => $request->registration_date
        ]);

        $registration->save();

        return new EventRegistrationResource($registration);
    }

    // API untuk menghapus pendaftaran event
    public function destroy($id)
    {
        $registration = EventRegistration::find($id);

        if (is_null($registration)) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $registration->delete();

        return response()->json(['message' => 'Registration deleted successfully']);
    }
}
