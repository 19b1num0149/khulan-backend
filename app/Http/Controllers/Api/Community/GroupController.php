<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupEventResource;
use App\Models\Group;
use App\Models\GroupEvent;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getGroup(Request $request)
    {
        $groups = Group::select('id', 'name', 'founded_year', 'description', 'user_id')
            ->where('id', $request->group_id)
            ->with('user:id,name')
            ->paginate(15);
            
        return response()->json(['events' => $groups], 200);
    }

    public function getEvent(Request $request)
    {
        $events = GroupEvent::select('id', 'group_id', 'name', 'description', 'date', 'creator_id')
            ->where('group_id', $request->group_id)
            ->with('creator:id,name')
            ->paginate(15);

        return new GroupEventResource($events);
    }
}
