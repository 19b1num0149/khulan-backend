<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\GroupMember;
use App\Models\UserPoint;
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
        $groupid = $request->groupid;

        $group = Group::with(['user:id,name'])
            ->select('id', 'name', 'founded_year', 'description', 'user_id')
            ->where('id', $groupid)
            ->first();
        $members_count = GroupMember::where('group_id', $groupid)
            ->count();

        $top_members = UserPoint::selectRaw('*, SUM(point) as total_sum')
            ->where('group_id', $groupid)
            ->with(['user:id,name'])
            ->groupBy('id')
            ->orderBy('total_sum', 'DESC')
            ->take(5)->get();

        $events = GroupEvent::where('group_id', $groupid)
            ->orderBy('created_at', 'DESC')
            ->take(2)->get();

        $contents = Content::where('group_id', $groupid)
            ->orderBy('created_at', 'DESC')
            ->take(2)->get();

        if (isset($group)) {
            return response()->json([
                'members_count' => $members_count,
                'top_members' => $top_members,
                'events' => $events,
                'contents' => $contents,
                'group' => $group], 200);
        }

        return response()->json(['msg' => trans('shared.failed')], 422);

    }

    public function about(Request $request)
    {
        $groupid = $request->groupid;

        $about = Group::with(['user:id,name'])
            ->select('id', 'name', 'founded_year', 'description', 'user_id', 'qr_data', 'created_at')
            ->where('id', $groupid)
            ->get();

        return response()->json(['about' => $about], 200);
    }

    public function contact(Request $request)
    {
        $groupid = $request->groupid;

        $contact = Group::with(['user:id,name'])
            ->select('id', 'name', 'founded_year', 'description', 'user_id', 'qr_data', 'created_at')
            ->where('id', $groupid)
            ->get();

        return response()->json(['contact' => $contact], 200);
    }

    public function leave(Request $request)
    {
        $user_id = $request->user_id;
        $groupid = $request->groupid;

        $body = GroupMember::where('member_id', $user_id)
            ->where('group_id', $groupid)
            ->first();

        $body->left_at = now();

        $body->save();

        return response()->json(['msg' => 'Successfully'], 200);
    }
}
