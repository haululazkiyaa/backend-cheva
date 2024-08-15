<?php

namespace App\Http\Controllers;

use App\Models\FavoriteEvent;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteEventController extends Controller
{
    // Menambahkan event ke daftar favorit user
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
        ]);

        $user = Auth::user();
        $eventId = $request->input('event_id');

        // Periksa apakah event sudah ada dalam daftar favorit
        $existingFavorite = FavoriteEvent::where('user_id', $user->user_id)
                                         ->where('event_id', $eventId)
                                         ->first();

        if ($existingFavorite) {
            return response()->json(['message' => 'Event is already in favorites'], 400);
        }

        $favorite = FavoriteEvent::create([
            'user_id' => $user->user_id,
            'event_id' => $eventId,
        ]);

        return response()->json([
            'message' => 'Event added to favorites',
            'data' => $favorite,
        ], 201);
    }

    // Menghapus event dari daftar favorit user
    public function destroy($eventId)
    {
        $user = Auth::user();

        // Cari event favorit yang akan dihapus
        $favorite = FavoriteEvent::where('user_id', $user->user_id)
                                 ->where('event_id', $eventId)
                                 ->first();

        if (!$favorite) {
            return response()->json(['message' => 'Favorite not found'], 404);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Event removed from favorites',
        ], 200);
    }

    // Mendapatkan daftar event favorit user
    public function index()
    {
        $user = Auth::user();
        $favorites = FavoriteEvent::with('event')
                                  ->where('user_id', $user->user_id)
                                  ->get();

        return response()->json([
            'data' => $favorites,
        ]);
    }
}
