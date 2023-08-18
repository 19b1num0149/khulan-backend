<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getGroups(Request $request)
    {
        $groups = Group::with(['user:id,name'])
            ->select('id', 'name', 'founded_year', 'description', 'user_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(15);

        return response()->json(['groups' => $groups], 200);
    }

    public function getGroup(Request $request)
    {
        $group_id = $request->group_id;

        $group = Group::with(['user:id,name'])
            ->select('id', 'name', 'founded_year', 'description', 'user_id')
            ->where('id', $group_id)
            ->first();

        return response()->json(['group' => $group], 200);
    }

    public function about(Request $request)
    {
        $group_id = $request->group_id;

        $about = Group::with(['user:id,name'])
            ->select('id', 'name', 'founded_year', 'description', 'user_id', 'qr_data', 'created_at')
            ->where('id', $group_id)
            ->get();

        return response()->json(['about' => $about], 200);
    }

    public function contact(Request $request)
    {
        $group_id = $request->group_id;

        $contact = Group::with(['user:id,name'])
            ->select('id', 'name', 'founded_year', 'description', 'user_id', 'qr_data', 'created_at')
            ->where('id', $group_id)
            ->get();

        return response()->json(['contact' => $contact], 200);
    }

    public function leave(Request $request)
    {
        $user_id = $request->user_id;
        $group_id = $request->group_id;

        $body = GroupMember::where('member_id', $user_id)
            ->where('group_id', $group_id)
            ->first();

        $body->left_at = now();

        $body->save();

        return response()->json(['msg' => 'Successfully'], 200);
    }
}
