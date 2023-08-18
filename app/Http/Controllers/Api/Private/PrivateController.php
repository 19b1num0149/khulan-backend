<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInterest;

class PrivateController extends Controller
{
    public function getUser($id)
    {

        $user = User::find($id);
        if (!isset($user)) {
            return response()->json(['msg' => 'User not found'], 404);
        }
        return response()->json(['msg' => 'Success', 'data' => $user], 200);
    }

    public function postUser(Request $request, $id)
    {
        $user = User::find($id);
    
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'address' => 'nullable|string',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,other',
        ]);
    
        $user->update($data);
    
        return response()->json(['msg' => 'success', 'data' => $user], 200);
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
        {
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

    public function getUserGroups($user_id)
    {
        $userGroups = GroupMember::where('member_id', $user_id)->get(); 
        if ($userGroups->isEmpty()) {
            return response()->json(['msg' => 'Хэрэглэгч бүлгэмд элсээгүй байна.'], 404);
        }
    
        return response()->json(['msg' => 'Success', 'data' => $userGroups], 200);
    }
    
    public function getJoinedGroupOfUser($user_id, $group_id)
    {
        $joinedGroup = GroupMember::where('member_id', $user_id)
        ->where('group_id', $group_id)
        ->first();
        

        if ($joinedGroup === null) {
            return response()->json(['msg' => 'Хэрэглэгч уг бүлгэмд элсээгүй байна.'], 404);
        }
            
        return response()->json(['msg' => 'Success', 'data' => $joinedGroup], 200);
    }
    
    
}
