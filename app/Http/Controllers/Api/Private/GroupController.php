<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupJoinRequest;
use App\Models\GroupMember;
use App\Models\UserPoint;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function getUserGroups($user_id)
    {
        $userGroups = Group::select( 'name', 'description', 'founded_year')
        ->selectSub(function ($query) {
            $query->selectRaw('COUNT(*)')
                ->from('group_members')
                ->whereColumn('group_members.group_id', 'groups.id');
        }, 'member_count')

        ->join('group_members', 'group_members.group_id', '=', 'groups.id')
        ->where('group_members.member_id', '=', $user_id)
        ->groupBy('groups.id')
        ->get();

        if ($userGroups->isEmpty()) {
            return response()->json(['msg' => 'Хэрэглэгч бүлгэмд элсээгүй байна.'], 404);
        }

        return response()->json(['msg' => 'Success', 'data' => $userGroups], 200);
    }

    public function getJoinedGroupOfUser($user_id, $group_id)
    {
        $rankedUserPoints = DB::table('user_points')
        ->select(['user_id', 'point', DB::raw('DENSE_RANK() OVER (PARTITION BY group_id ORDER BY point DESC) AS `rank`')])
        ->where('group_id', $group_id);
    
        $rank = DB::table(DB::raw("({$rankedUserPoints->toSql()}) as RankedUserPoints"))
            ->mergeBindings($rankedUserPoints)
            ->select('point', DB::raw('`rank`'))
            ->where('user_id', $user_id)
            ->get();


        $memberCount = GroupMember::where('group_id', $group_id)->count();

        $result = [
            'user_point' => $rank,
            'member_count' => $memberCount,
        ];

        $joinedGroup = GroupMember::where('member_id', $user_id)
            ->where('group_id', $group_id)
            ->first();
        if ($joinedGroup === null) {
            return response()->json(['msg' => 'Хэрэглэгч уг бүлгэмд элсээгүй байна.'], 404);
        }

        return response()->json(['msg' => 'Success', 'data' => $result], 200);
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
