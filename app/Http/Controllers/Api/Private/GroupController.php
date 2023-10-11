<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupInterest;
use App\Models\GroupJoinRequest;
use App\Models\GroupMember;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function getUserGroups(Request $request, $user_id)
    {

        $data = [];

        if ($request->has('name') && strlen($request->name) > 0) {

            $groups = Group::withCount(['members'])->FilterName($request->name)->limit(10)->get();

            if ($groups->count() > 0) {
                foreach ($groups as $group) {
                    $data[] = (object) [
                        'id' => $group->id,
                        'name' => $group->name,
                        'logo' => $group->picture,
                        'description' => $group->description,
                        'founded' => $group->founded_year,
                        'members' => $group->members_count,
                    ];
                }
            }

        } else {

            // Empty state ( array )
            $interests = [];

            // Getting user by auth from request ;
            $userid = $request->user()->id;
            // Users interests
            $interestData = UserInterest::where('user_id', $userid)->get();
            if ($interestData->count() > 0) {
                foreach ($interestData as $item) {
                    $interests[] = $item->interest_id;
                }
            }

            // Find for suggestions
            $groups = GroupInterest::with(['group.members'])->whereIn('interest_id', $interests)->limit('10')->get();

            if ($groups->count() > 0) {
                foreach ($groups as $item) {
                    $data[] = (object) [
                        'id' => $item->group?->id,
                        'name' => $item->group?->name,
                        'logo' => $item->group?->picture,
                        'description' => $item->group?->description,
                        'founded' => $item->group?->founded_year,
                        'members' => $item->group->members->count(),
                    ];
                }
            }

        }

        $responseData = [
            'msg' => 'Success',
            'data' => $data,
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
