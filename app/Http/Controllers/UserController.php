<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        return response()->json([
            'users' => User::orderBy('id', 'DESC')->limit(5)->get(),
        ], 200);
    }
}
