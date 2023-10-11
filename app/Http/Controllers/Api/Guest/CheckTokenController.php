<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke(Request $request)
    {
        return response()->json([
            'msg' => trans('shared.success'),
            'user' => $request->user(),
        ], 200);
    }
}
