<?php

namespace App\Http\Controllers\Api\Guest;

use App\Events\ResendCode;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResendVerificationCodeController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        ResendCode::dispatch($user);

        return response()->json(['message' => trans('auth.success_resend_code')], 200);
    }
}
