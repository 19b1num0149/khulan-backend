<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers(Request $request) 
    {
        return response()->json([
            'users' => User::orderBy('id', 'DESC')->limit(5)->get()
        ], 200);
    }
}
