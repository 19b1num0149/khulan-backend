<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Request\Guest\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // public function authenticate(LoginRequest $request) {

    //     $user = User::where('phone', $request->phone)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json(['msg' => 'Утасны дугаар эсвэл нууц үг буруу байна.'], 200 );
    //     }

    //     if($user->is_active == 0) {
    //         return response()->json(['code' => '3000',
    //                                  'msg' => 'Хаяг идэвхгүй байна'], 200);
    //     }

    //     return response()->json(['code' => '1000',
    //                              'token' => $user->createToken($request->device_name)->plainTextToken,
    //                              'profile' => $user], 200);
    // }

    // public function registerByEmail(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:clients',
    //         'password' => ['required', new StrongPassword]
    //     ]);

    //     Client::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => $request->password,
    //         'company_id' => $request->header('Company-Id'),
    //         'active' => 0 ]);

    //     return response()->json(['msg' => 'Амжилттай бүртэглээ.'], 200);
    // }

    // public function activate_account(Request $request) {

    //     $code = DB::table('users_verifications')
    //               ->select('code')
    //               ->where('email', $request->email)
    //               ->where('expired_at', '>=', Carbon::now())
    //               ->orderBy('created_at', 'DESC')
    //               ->first();

    //     if($code == null) {
    //         return response()->json(['msg' => 'Код илгээгдээгүй байна.'], 200);
    //     }

    //     if($code->code == $request->code) {
    //         $verification = User::where('email' , $request->email)->first();
    //         $verification->used_at = Carbon::now();
    //         $verification->save();
    //         return response()->json(['msg' => 'Амжилттай.'], 200);
    //     }

    //     return response()->json(['msg' => 'Код таарахгүй байна.'], 200);

    // }

    // public function logout(Request $request) {

    //     $request->user()->tokens()->delete();
    //     return response()->json(['msg' => 'Системээс гарлаа.'], 200);

    // }

}
