<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\GroupEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getEvent(Request $request)
    {

        $events = GroupEvent::select('id', 'group_id', 'name', 'description', 'date', 'creator_id')
            ->where('group_id', $request->group_id)
            ->with('creator:id,name')
            ->with('group:id,name')
            ->paginate(15);
        $transformedEvents = [];

        foreach ($events as $events) {
            $transformedEvents[] = [
                'id' => $events->id,
                'group' => $events->group,
                'name' => $events->name,
                'description' => $events->description,
                'date' => $events->date,
                'creator' => $events->creator,
            ];
        }

        return response()->json(['events' => $transformedEvents], 200);

    }
}
