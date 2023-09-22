<?php

namespace App\Http\Controllers\Company\Temple;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Temple\StoreItemActivityRequest;
use App\Models\Temple\TempleQrItemActivity;
use Illuminate\Http\Request;

class QrItemActivityController extends Controller
{
    public function index(Request $request)
    {
        $data = TempleQrItemActivity::FilterName($request->search)
            ->where('item_id', $request->item)
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json(['activity' => $data], 200);
    }

    public function store(StoreItemActivityRequest $request, $itemid)
    {
        $activity = new TempleQrItemActivity;
        $activity->item_id = $itemid;
        $activity->who = $request->who;
        $activity->activity_date = $request->activitydate;
        $activity->activity = $request->activity;
        $activity->save();

        return response()->json(['success' => trans('shared.saved_successfully')]);

    }

    public function update(StoreItemActivityRequest $request, $itemid, $id)
    {
        $activity = TempleQrItemActivity::find($id);
        $activity->item_id = $itemid;
        $activity->who = $request->who;
        $activity->activity_date = $request->activitydate;
        $activity->activity = $request->activity;
        $activity->save();

        return response()->json(['success' => trans('shared.saved_successfully')]);

    }

    public function destroy(Request $request, $itemid, $id)
    {
        TempleQrItemActivity::destroy($id);

        return response()->json(['success' => trans('shared.deleted_successfully')]);
    }
}
