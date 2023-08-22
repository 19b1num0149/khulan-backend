<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Http\Request\Api\Guest\LoginRequest;
use App\Models\User;
use App\Rules\StrongPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['msg' => 'И-мэйл эсвэл нууц үг буруу байна.'], 200);
        }

        if ($user->email_verified_at == null) {
            return response()->json(['msg' => 'Хаяг идэвхгүй байна'], 200);
        }

        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken,
            'profile' => $user], 200);
    }

}
