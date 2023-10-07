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
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{

    public function registerByEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', new StrongPassword],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'role_id' => 3
        ]);

        return response()->json([
            'msg' => 'Амжилттай бүртэглээ.',
            'email' => $user->email
        ], 200);
    }

    public function registerByFacebook(Request $request)
    {
        try {
        
            $user = Socialite::driver('facebook')->user();
         
            $finduser = User::where('fb_id', $user->id)->first();
         
            if($finduser){
         
                return response()->json(['token' => $finduser->createToken($finduser->id)->plainTextToken,
                                         'profile' => $user], 200);
         
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->name,
                        'fb_id'=> $user->id,
                        'password' => encrypt('123456@facebook')
                    ]);
        
        
                return response()->json(['token' => $newUser->createToken($newUser->id)->plainTextToken,
                                         'profile' => $newUser], 200);
            }
       
        } catch (Exception $e) {
            // dd($e->getMessage());
        }
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
            return response()->json(['msg' => 'Буруу код байна.'], 422);
        }

        if ($code->code == $request->code) {
            // $user = User::where('email', $request->email)->first();
            // $user->email_verified_at = Carbon::now();
            // $user->save();
            return response()->json(['msg' => 'Амжилттай.'], 200);
        }

        return response()->json(['msg' => 'Код таарахгүй байна.'], 422);

    }
}
