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

    public function update(Request $request, $id)
    {
        // Mencari event berdasarkan ID
        $event = Event::find($id);

        if (is_null($event)) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'event_name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'category' => 'sometimes|required|string|max:20',
            'start_date' => 'sometimes|required|date',
            'finish_date' => 'sometimes|required|date',
            'start_time' => 'sometimes|required|date_format:H:i:s',
            'finish_time' => 'sometimes|required|date_format:H:i:s',
            'location' => 'sometimes|required|string|max:30',
            'contact_person' => 'sometimes|required|string|max:15',
            'registration_link' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:oncoming,ongoing,finished',
            'user_id' => 'sometimes|required|exists:users,user_id',
            'poster_file' => 'sometimes|required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Memperbarui poster_file jika ada file baru
        if ($request->hasFile('poster_file')) {
            // Hapus file poster lama
            if ($event->poster_file_path) {
                Storage::disk('public')->delete($event->poster_file_path);
            }

            // Simpan file poster baru
            $poster_file_path = $request->file('poster_file')->store('posters', 'public');
            $event->poster_file_path = $poster_file_path;
        }

        // Memperbarui data event dengan input yang baru
        $event->update($request->only([
            'event_name',
            'description',
            'category',
            'start_date',
            'finish_date',
            'start_time',
            'finish_time',
            'location',
            'contact_person',
            'registration_link',
            'status',
            'user_id',
        ]));

        // Mengembalikan response dengan resource
        return new EventResource($event);
    }
}
