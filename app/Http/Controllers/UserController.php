<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show() {
        $user = Auth::user();

        return new UserResource($user);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|string|max:50',
            'email' => 'sometimes|string|email|max:30',
            'profile_picture_path' => 'sometimes|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->username = $request->username ?? $user->username;
        $user->email = $request->email ?? $user->email;
        $user->profile_picture_path = $request->profile_picture_path ?? $user->profile_picture_path;

        $user->save();

        return new UserResource($user);
    }

    public function verification(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'id_card_picture' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'id_card_picture_path' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('id_card_picture')) {
            $validator = Validator::make($request->all(), [
                'id_card_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $idCardPicturePath = $request->file('id_card_picture')->store('public/id_cards');
        } else {
            $idCardPicturePath = $request->id_card_picture_path;
        }

        $user->id_card_picture_path = $idCardPicturePath;
        $user->save();

        return response()->json([
            'message' => 'Verification successfully',
            'data' => new UserResource($user)
        ]);
    }

}
