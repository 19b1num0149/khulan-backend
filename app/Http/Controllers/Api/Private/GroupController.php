<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\GroupJoinRequest;
use App\Models\GroupMember;

class GroupController extends Controller
{
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

    public function createGroupJoinRequest($user_id, $group_id)
    {
        $joinRequest = new GroupJoinRequest();
        $joinRequest->user_id = $user_id;
        $joinRequest->group_id = $group_id;
        $joinRequest->save();

        return response()->json(['msg' => 'Хүсэлт амжилттай илгээгдлээ.'], 200);
    }
}