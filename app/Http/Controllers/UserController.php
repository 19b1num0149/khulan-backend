<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        return response()->json([
            'users' => User::with('role:id,permission_id')->get(),
        ], 200);
    }
}
