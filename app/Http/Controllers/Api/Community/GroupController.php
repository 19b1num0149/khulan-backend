<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getGroups(Request $request)
    {
        $groups = Group::select('id', 'name', 'founded_year', 'description', 'user_id')
            ->where('id', $request->group_id)
            ->with('user:id,name')
            ->paginate(15);

        $transformedGroups = [];

        foreach ($groups as $groups) {
            $transformedGroups[] = [
                'id' => $groups->id,
                'name' => $groups->name,
                'founded_year' => $groups->founded_year,
                'description' => $groups->description,
                'user' => $groups->user,
            ];
        }

        return response()->json(['groups' => $transformedGroups], 200);
    }
}
