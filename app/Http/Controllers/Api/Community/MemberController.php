<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getMembers(Request $request)
    {
        $groupid = $request->groupid;

        $structure = $request->filter_by_structure;

        $joined = $request->filter_by_joined;

        $rank = $request->filter_by_rank;

        $members = GroupMember::with(['member:id,name'])
            ->select('*, SUM(user_points.point) as total point')
            ->join('user_points', 'group_members.member_id', '=', 'user_points.user_id')
            ->select('group_members.member_id', GroupMember::raw('SUM(user_points.point) as total_points'))
            ->where('group_members.group_id', $groupid)
            ->groupBy('group_members.member_id');

        if ($joined) {
            $members = $members->joined();
        }

        if ($structure) {
            $members = $members->structure();
        }

        if ($rank) {
            $members = $members->rank();
        }

        $members = $members->paginate(15);

        return response()->json(['members' => $members], 200);
    }
}
