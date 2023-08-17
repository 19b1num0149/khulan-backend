<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Http\Request\Api\Guest\LoginRequest;
use App\Http\Request\Api\Guest\RegisterRequest;
use App\Models\User;

use App\Rules\StrongPassword;

class LoginController extends Controller {

    // public function authenticate(LoginRequest $request) {

<<<<<<< HEAD
        $user = User::where('email', $request->email)->first();
=======
    //     $user = User::where('phone', $request->phone)->first();
>>>>>>> 532fbed (community api)

        
    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json(['msg' => 'Утасны дугаар эсвэл нууц үг буруу байна.'], 200 );   
    //     }

<<<<<<< HEAD
        if($user->email_verified_at == null) {
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
            'password' => ['required', new StrongPassword]
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone ]);
=======
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
>>>>>>> 532fbed (community api)

    //     return response()->json(['msg' => 'Амжилттай бүртэглээ.'], 200);
    // }

    // public function activate_account(Request $request) {

<<<<<<< HEAD
        $code = DB::table('user_verifications')
                  ->select('code')
                  ->where('email', $request->email)
                  ->where('expired_at', '>=', Carbon::now())
                  ->orderBy('created_at', 'DESC')
                  ->first();
=======
    //     $code = DB::table('users_verifications')
    //               ->select('code')
    //               ->where('email', $request->email)
    //               ->where('expired_at', '>=', Carbon::now())
    //               ->orderBy('created_at', 'DESC')
    //               ->first();
>>>>>>> 532fbed (community api)

    //     if($code == null) {
    //         return response()->json(['msg' => 'Код илгээгдээгүй байна.'], 200);
    //     }

<<<<<<< HEAD
        if($code->code == $request->code) {
            $verification = User::where('email' , $request->email)->first();
            $verification->email_verified_at = Carbon::now();
            $verification->save();
            return response()->json(['msg' => 'Амжилттай.'], 200);
        }
=======
    //     if($code->code == $request->code) {
    //         $verification = User::where('email' , $request->email)->first();
    //         $verification->used_at = Carbon::now();
    //         $verification->save();
    //         return response()->json(['msg' => 'Амжилттай.'], 200);
    //     }
>>>>>>> 532fbed (community api)

    //     return response()->json(['msg' => 'Код таарахгүй байна.'], 200);

    // }

    // public function logout(Request $request) {

    //     $request->user()->tokens()->delete();
    //     return response()->json(['msg' => 'Системээс гарлаа.'], 200);

    // }
    
} 
