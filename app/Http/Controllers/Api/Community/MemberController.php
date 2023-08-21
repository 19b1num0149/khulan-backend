<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getMembers(Request $request)
    {
        $group_id = $request->group_id;

        $structrue = $request->filter_by_structrue;

        // 1. Rank
        // 2. Joined

        $members = GroupMember::with(['group:id,name', 'member:id,name'])
            ->select('group_id', 'member_id', 'role_id', 'joined_at', 'left_at')
            ->where('group_id', $group_id);

        if ($structrue) {
            $members = $members->joined();
        }

        $members->simplePaginate(15);

        return response()->json(['members' => $members], 200);
    }
}
