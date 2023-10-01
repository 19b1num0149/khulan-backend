<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $items = Group::get();

        Log::info($items);

        return Inertia::render('Dashboard',[
            'items' => $items
        ]);
    }
}
