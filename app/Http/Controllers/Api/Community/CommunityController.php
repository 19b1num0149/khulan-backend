<?php

namespace app\Http\Controllers\Api\Community;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Group_Event;


class CommunityController extends Controller{
    
    public function getEvent(Request $request)
    {
        $events = Group_Event::with('creator')->paginate(15);
        return response()->json(['events' => $events], 200);
    }

    public function getContents(Request $request)
    {
        $contents = Content::with('group')->paginate(15);
        return response()->json(['contents' => $contents], 200);
    }
}