<?php

namespace App\Http\Controllers\Api\Guest;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Events\ResendCode;


class ResendVerificationCodeController extends Controller
{
    public function resendCode(Request $request)
    {
        $request->validate([            
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        ResendCode::dispatch($user);

        return response()->json(['message' => trans('auth.success_resend_code')], 200);
    }

}
