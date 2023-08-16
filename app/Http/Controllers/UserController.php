<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->limit(5)->get();
        return response()->json(['users' => $users], 200);
    }
}
