<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show() {
        $user = Auth::user();

        return new UserResource($user);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->update($request->all());

        return new UserResource($user);
    }
}
