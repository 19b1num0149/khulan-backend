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
    // Query to get groups with matching interests
    $groupsSuggested = Group::select('groups.id', 'name', 'description', 'founded_year')
        ->selectSub(function ($query) use ($user_id) {
            $query->selectRaw('COUNT(*)')
                ->from('group_members')
                ->whereColumn('group_members.group_id', 'groups.id');
        }, 'member_count')
        ->selectSub(function ($query) use ($user_id) {
            $query->selectRaw('1')
                ->from('group_members')
                ->whereColumn('group_members.group_id', 'groups.id')
                ->where('group_members.member_id', $user_id);
        }, 'is_member')
        ->selectSub(function ($query) use ($user_id) {
            $query->selectRaw('1')
                ->from('group_join_requests')
                ->whereColumn('group_join_requests.group_id', 'groups.id')
                ->where('group_join_requests.user_id', $user_id);
        }, 'join_request_sent')
        ->leftJoin('group_members', function ($join) use ($user_id) {
            $join->on('group_members.group_id', '=', 'groups.id')
                ->where('group_members.member_id', $user_id);
        })
        ->whereExists(function ($query) use ($user_id) {
            $query->selectRaw(1)
                ->from('group_interests')
                ->whereColumn('group_interests.group_id', 'groups.id')
                ->whereIn('group_interests.interest_id', function ($subquery) use ($user_id) {
                    $subquery->select('interest_id')
                        ->from('user_interests')
                        ->where('user_id', $user_id);
                });
        })
        ->groupBy('groups.id', 'name', 'description', 'founded_year')
        ->get();

    // Query to get all groups, including is_member and join_request_sent columns
    $allGroups = Group::select('groups.id', 'name', 'description', 'founded_year')
        ->selectSub(function ($query) {
            $query->selectRaw('COUNT(*)')
                ->from('group_members')
                ->whereColumn('group_members.group_id', 'groups.id');
        }, 'member_count')
        ->selectSub(function ($query) use ($user_id) {
            $query->selectRaw('1')
                ->from('group_members')
                ->whereColumn('group_members.group_id', 'groups.id')
                ->where('group_members.member_id', $user_id);
        }, 'is_member')
        ->selectSub(function ($query) use ($user_id) {
            $query->selectRaw('1')
                ->from('group_join_requests')
                ->whereColumn('group_join_requests.group_id', 'groups.id')
                ->where('group_join_requests.user_id', $user_id);
        }, 'join_request_sent')
        ->leftJoin('group_members', function ($join) use ($user_id) {
            $join->on('group_members.group_id', '=', 'groups.id')
                ->where('group_members.member_id', $user_id);
        })
        ->groupBy('groups.id', 'name', 'description', 'founded_year')
        ->get();

    $responseData = [
        "msg" => "Success",
        "suggests" => $groupsSuggested,
        "allGroups" => $allGroups,
    ];

    return response()->json($responseData, 200);
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
        $existingJoinRequest = GroupJoinRequest::where('user_id', $user_id)
            ->where('group_id', $group_id)
            ->first();
    
        if ($existingJoinRequest) {
            $existingJoinRequest->delete();
        }
    
        $joinRequest = new GroupJoinRequest();
        $joinRequest->user_id = $user_id;
        $joinRequest->group_id = $group_id;
        $joinRequest->save();
    
        return response()->json(['msg' => 'Хүсэлт амжилттай илгээгдлээ.'], 200);
    }
    
}
