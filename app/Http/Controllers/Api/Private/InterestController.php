<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInterest;
use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{


    public function getAllInterest()
    {
        $interests = Interest::orderBy('description', 'ASC')->get();
        return response()->json([
            'msg' => 'Success', 
            'interests' => $interests], 200);
    }

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
        $user = User::find($user_id);
        if (! isset($user)) {
            return response()->json(['msg' => trans('shared.failed')], 422);
        }

        $data = $request->validate([
            'interest_id' => 'required|integer',
        ]);

        $userInterest = new UserInterest();
        $userInterest->user_id = $user_id;
        $userInterest->interest_id = $data['interest_id'];
        $userInterest->save();

        return response()->json(['msg' => 'Success', 'data' => $userInterest], 200);

    }
}
