<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    // API untuk melihat semua event
    public function index()
    {
        // Mengambil semua event dari database
        $events = Event::all();

        // Mengembalikan response dengan resource (opsional)
        return EventResource::collection($events);
    }

    // API untuk melihat detail suatu event berdasarkan ID
    public function show($id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    // API untuk menambahkan event
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:20',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'finish_time' => 'required|date_format:H:i:s',
            'location' => 'required|string|max:30',
            'contact_person' => 'required|string|max:15',
            'registration_link' => 'required|string|max:255',
            'status' => 'required|in:oncoming,ongoing,finished',
            'user_id' => 'required|exists:users,user_id',
            'poster_file' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $poster_file_path = $request->file('poster_file')->store('posters', 'public');

        $event = Event::create([
            'event_name' => $request->event_name,
            'description' => $request->description,
            'category' => $request->category,
            'start_date' => $request->start_date,
            'finish_date' => $request->finish_date,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time,
            'location' => $request->location,
            'contact_person' => $request->contact_person,
            'poster_file_path' => $poster_file_path,
            'registration_link' => $request->registration_link,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);

        return new EventResource($event);
    }

    // API untuk mengupdate event
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:20',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'finish_time' => 'required|date_format:H:i:s',
            'location' => 'required|string|max:30',
            'contact_person' => 'required|string|max:15',
            'registration_link' => 'required|string|max:255',
            'status' => 'required|in:oncoming,ongoing,finished',
            'user_id' => 'required|exists:users,user_id',
            'poster_file' => 'image|max:2048', // validasi untuk file gambar
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $updatedData = [
            'event_name' => $request->event_name,
            'description' => $request->description,
            'category' => $request->category,
            'start_date' => $request->start_date,
            'finish_date' => $request->finish_date,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time,
            'location' => $request->location,
            'contact_person' => $request->contact_person,
            'registration_link' => $request->registration_link,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ];

        if ($request->hasFile('poster_file')) {
            // menghapus file gambar lama dari storage
            Storage::disk('public')->delete($event->poster_file_path);

            // menyimpan file gambar baru ke storage dan mendapatkan path-nya
            $poster_file_path = $request->file('poster_file')->store('posters', 'public');

            $updatedData['poster_file_path'] = $poster_file_path;
        }

        // update atribut lainnya
        $event->update($updatedData);

        return new EventResource($event);
    }
}
