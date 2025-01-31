<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\GroupEvent;
use App\Models\GroupEventMember;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getEvents(Request $request)
    {
        $groupid = $request->groupid;

        $events = GroupEvent::with(['creator:id,name',
            'group:id,name'])
            ->select('id', 'group_id', 'name', 'description', 'date', 'creator_id', 'created_at')
            ->where('group_id', $groupid)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(15);

        return response()->json(['events' => $events], 200);

    }

    public function getEvent(Request $request)
    {
        $id = $request->id;
        $groupid = $request->groupid;

        $event = GroupEvent::with(['creator:id,name',
            'group:id,name',
            'itineraries'])
            ->withCount(['members'])
            ->select('id', 'group_id', 'name', 'description', 'date', 'creator_id')
            ->where('id', $id)
            ->where('group_id', $groupid)
            ->first();

        if (isset($event)) {
            return response()->json(['event' => $event], 200);
        }

        return response()->json(['msg' => trans('shared.failed')], 422);

    }

    public function postEvent(Request $request)
    {
        $body = new GroupEventMember();

        $body->group_id = $request->groupid;
        $body->event_id = $request->id;
        $body->member_id = $request->member_id;
        $body->joined_at = now();

        $body->save();

        return response()->json(['msg' => 'Successfully'], 200);

    }
}
