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

    public function registerByEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', new StrongPassword],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone]);

        return response()->json(['msg' => 'Амжилттай бүртэглээ.'], 200);
    }

    public function activate_account(Request $request)
    {

        $code = DB::table('user_verifications')
            ->select('code')
            ->where('email', $request->email)
            ->where('expired_at', '>=', Carbon::now())
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($code == null) {
            return response()->json(['msg' => 'Код илгээгдээгүй байна.'], 200);
        }

        if ($code->code == $request->code) {
            $verification = User::where('email', $request->email)->first();
            $verification->email_verified_at = Carbon::now();
            $verification->save();

            return response()->json(['msg' => 'Амжилттай.'], 200);
        }

        return response()->json(['msg' => 'Код таарахгүй байна.'], 200);

    }
}
