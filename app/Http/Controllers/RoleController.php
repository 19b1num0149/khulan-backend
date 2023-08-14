<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getGroups(Request $request)
    {
        return response()->json([
            'role' => Role::get(),
        ], 200);
    }
}
