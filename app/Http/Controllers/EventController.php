<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    //
    public function index()
    {
        // Mengambil semua event dari database
        $events = Event::all();

        // Mengembalikan response dengan resource (opsional)
        return EventResource::collection($events);
    }
}
