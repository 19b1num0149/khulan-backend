<?php

namespace App\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Http\Request\Api\Private\UserSettingsRequest;
use App\Models\UserSettings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getData(Request $request)
    {

        $data = UserSettings::where('user_id', $request->user()->id)->get();

        return response()->json(['msg' => 'success', 'data' => $data], 200);
    }

    public function store(UserSettingsRequest $request)
    {

        $data = UserSettings::where('user_id', $request->user()->id)->first();
        $data->event_off = $request->event_off;
        $data->content_on = $request->content_on;
        $data->coupon = $request->coupon;
        $data->save();

        return response()->json(['msg' => 'Амжилттай хадгаллаа'], 200);

    }
}
