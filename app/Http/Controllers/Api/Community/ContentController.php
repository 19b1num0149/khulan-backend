<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\UserPoint;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getContents(Request $request)
    {
        $groupid = $request->groupid;

        $contents = Content::with('group:id,name')
            ->select('id', 'group_id', 'body', 'point', 'type', 'slug', 'created_at')
            ->where('group_id', $groupid)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(15);

        return response()->json(['contents' => $contents], 200);

    }

    public function getContent(Request $request)
    {

        $id = $request->id;
        $groupid = $request->groupid;

        $content = Content::with('group:id,name')
            ->select('id', 'group_id', 'body', 'point', 'type', 'slug', 'created_at')
            ->where('id', $id)
            ->where('group_id', $groupid)
            ->first();

        if (isset($event)) {
            return response()->json(['content' => $content], 200);
        }

        return response()->json(['msg' => trans('shared.failed')], 422);

    }

    public function earnPointFromContent(Request $request)
    {
        $id = $request->id;
        $groupid = $request->groupid;

        $content = Content::with('group:id,name')
            ->select('id', 'group_id', 'body', 'point', 'type', 'slug', 'created_at')
            ->where('id', $id)
            ->where('group_id', $groupid)
            ->first();

        $body = new UserPoint();

        $body->user_id = $request->user_id;
        $body->group_id = $groupid;
        $body->point = $content->point;

        $body->save();

        return response()->json(['msg' => 'Successfully'], 200);
    }
}
