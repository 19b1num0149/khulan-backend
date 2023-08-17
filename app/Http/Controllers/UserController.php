<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $users = User::paginate(15);
        return response()->json(['users' => $users], 200);
    }
}
