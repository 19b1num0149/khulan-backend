<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getMembers(Request $request)
    {
        $members = GroupMember::select('group_id', 'member_id', 'role_id', 'joined_at', 'left_at')
            ->where('group_id', $request->group_id)
            ->with('group:id,name')
            ->with('member:id,name')
            ->paginate(15);

        $transformedMembers = [];

        foreach ($members as $members) {
            $transformedMembers[] = [
                'group' => $members->group,
                'member' => $members->member,
                'role_id' => $members->role_id,
                'joined_at' => $members->joined_at,
                'left_at' => $members->left_at,
            ];
        }

        return response()->json(['members' => $transformedMembers], 200);
    }
}
