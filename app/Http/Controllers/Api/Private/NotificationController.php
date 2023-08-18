<?php

namespace App\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Request\Api\Private\UserSettingsRequest;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationController extends Controller{

    public function getData(Request $request) {

        $data = Notification::where('user_id' , $request->user()->id)
                            ->orderBy('id' , 'DESC')
                            ->simplepaginate(15);
        return response()->json(['msg' => 'success' , 'data' => $data] , 200);

    }

    public function read(Request $request , $notifid) {

        $data = new Notification;
        $data->user_id = $request->user()->id;
        $data->notification_id = $notifid;
        $data->read_at = Carbon::now();
        $data->save();

        return response()->json(['msg' => 'Амжилттай хадгаллаа'] , 200);

    }
}