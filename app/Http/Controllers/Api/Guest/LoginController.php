<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Http\Request\Api\Guest\LoginRequest;
use App\Models\User;
use App\Models\UserInterest;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(LoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => ['phone' => ['Утасны дугаар эсвэл нууц үг буруу байна.']],
            ], 422);
        }


        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'profile' => [
                'user' => $user,
            ],
        ], 200);
    }

}

