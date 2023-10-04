<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GroupController extends Controller
{
    public function index(Request $request): Response
    {
        $data = Group::orderBy('id', 'DESC')->paginate(50)->withQueryString();

        return Inertia::render('group/index', [
            'data' => $data,
        ]);
    }

    public function create(): Response
    {
        $users = User::orderBy('name', 'ASC')->get();

        return Inertia::render('group/create', [
            'users' => $users,
        ]);
    }

    public function show(Request $request, $id): Response
    {   
        $data = Group::findOrFail($id);
        return Inertia::render('group/show', [
            'data' => $data,
        ]);
    }
}