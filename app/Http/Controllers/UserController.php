<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();

        return UserResource::collection($users); 
    }
    public function show($id) {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = User::findOrFail($id);
        $product->update($request->all());

        return $product;
    }
}
