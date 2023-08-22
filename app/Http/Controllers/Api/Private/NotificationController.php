<?php

namespace App\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getData(Request $request)
    {

        $data = UserNotification::where('user_id', $request->user()->id)
            ->orderBy('id', 'DESC')
            ->simplepaginate(15);

        return response()->json(['msg' => 'success', 'data' => $data], 200);

    }

    public function read(Request $request, $notifid)
    {

        $data = new UserNotification;
        $data->user_id = $request->user()->id;
        $data->notification_id = $notifid;
        $data->read_at = Carbon::now();
        $data->save();

        return response()->json(['msg' => 'Амжилттай хадгаллаа'], 200);

    }
}
