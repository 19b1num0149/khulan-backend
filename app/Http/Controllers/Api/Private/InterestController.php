<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInterest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function getUserInterest($user_id)
    {
        $userInterest = UserInterest::where('user_id', $user_id)->get();

        if ($userInterest->isEmpty()) {
            return response()->json(['msg' => 'User interest not found'], 404);
        }

        return response()->json(['msg' => 'Success', 'data' => $userInterest], 200);
    }

    public function postUserInterest(Request $request, $user_id)
    {
        UserInterest::where('user_id', $user_id)->delete();
    
        $user = User::find($user_id);
        
        if (!isset($user)) {
            return response()->json(['msg' => trans('shared.failed')], 422);
        }
    
        $data = $request->validate([
            'interest_ids' => 'required|array',
            'interest_ids.*' => 'integer', 
        ]);
    
        foreach ($data['interest_ids'] as $interest_id) {
            $userInterest = new UserInterest();
            $userInterest->user_id = $user_id;
            $userInterest->interest_id = $interest_id;
            $userInterest->save();
        }
    
        return response()->json(['msg' => 'Success'], 200);
    }
}
