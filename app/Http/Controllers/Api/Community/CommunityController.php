<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupEventResource;
use App\Models\Content;
use App\Models\GroupEvent;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    protected $group_id;

    public function __construct()
    {
        // Logic, middleware
        //$this->group_id = 1;
    }

    public function getEvent(Request $request)
    {
        $events = GroupEvent::select('id', 'name', 'description', 'date', 'creator_id')
            ->with('creator:id,name')
            ->paginate(15);
        //return response()->json(['events' => $events], 200);
        return new GroupEventResource($events);
    }

    public function getContents(Request $request)
    {
        $contents = Content::with('group')->paginate(15);

        return response()->json(['contents' => $contents], 200);
    }
}
