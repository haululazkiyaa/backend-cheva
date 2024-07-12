<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Http\Request;
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
}

