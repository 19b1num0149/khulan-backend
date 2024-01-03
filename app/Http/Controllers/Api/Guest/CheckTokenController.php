<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInterest;

class CheckTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();
        $requiredFields = ['name', 'email', 'phone', 'address', 'birthday', 'gender'];
        
        $interestsCount = UserInterest::where('user_id', $user->id)->count();

        $isComplete = $this->checkProfileCompletion($user, $requiredFields, $interestsCount);

        return response()->json([
            'msg' => trans('shared.success'),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'phone' => $user->phone,
                'birthday' => $user->birthday,
                'gender' => $user->gender,
                'address' => $user->address,
                'is_complete' => $isComplete,
            ],
        ], 200);
    }

    private function checkProfileCompletion($user, $fields, $interestsCount)
    {
        foreach ($fields as $field) {
            if (empty($user->{$field})) {
                return false;
            }
        }
        
        return ($interestsCount >= 3);
    }
}

