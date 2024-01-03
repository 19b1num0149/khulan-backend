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
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => ['email' => ['И-мэйл эсвэл нууц үг буруу байна.']],
            ], 422);
        }

        $profileCompleteness = $this->checkProfileCompleteness($user);

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'profile' => [
                'user' => $user,
                'is_complete' => $profileCompleteness,
            ],
        ], 200);
    }

    private function checkProfileCompleteness($user)
    {
        $requiredFields = ['name', 'email', 'phone', 'address', 'birthday', 'gender'];

        $interestsCount = UserInterest::where('user_id', $user->id)->count();

        foreach ($requiredFields as $field) {
            if (empty($user->{$field})) {
                return false;
            }
        }

        return ($interestsCount >= 3);
    }
}

