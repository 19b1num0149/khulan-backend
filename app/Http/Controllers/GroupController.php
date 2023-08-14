<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function getGroups(Request $request)
    {
        return response()->json([
            'group' => Group::orderBy('id', 'DESC')->limit(5)->get(),
        ], 200);
    }
}