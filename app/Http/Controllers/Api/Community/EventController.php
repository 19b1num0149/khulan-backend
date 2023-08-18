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
        $group_id = $request->group_id;

        $events = GroupEvent::with(['creator:id,name', 'group:id,name'])
            ->select('id', 'group_id', 'name', 'description', 'date', 'creator_id')
            ->where('group_id', $group_id)
            ->simplePaginate(15);

        return response()->json(['events' => $events], 200);

    }

    public function getEvent(Request $request)
    {
        $id = $request->id;
        $group_id = $request->group_id;

        $event = GroupEvent::with(['creator:id,name', 'group:id,name'])
            ->select('id', 'group_id', 'name', 'description', 'date', 'creator_id')
            ->where('id', $id)
            ->where('group_id', $group_id)
            ->first();

        return response()->json(['event' => $event], 200);

    }

    public function postEvent(Request $request)
    {
        $body = new GroupEventMember();

        $body->group_id = $request->group_id;
        $body->event_id = $request->event_id;
        $body->member_id = $request->member_id;
        $body->joined_at = now();

        $body->save();

        return response()->json(['msg' => 'Successfully'], 200);

    }
}
