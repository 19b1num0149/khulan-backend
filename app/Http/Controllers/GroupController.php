<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Role;

class GroupController extends Controller
{
    public function getGroups(Request $request)
    {
        return response()->json([
            'group' => Group::with('user:id,name,email_verified_at')->get(),
        ], 200);
    }
}