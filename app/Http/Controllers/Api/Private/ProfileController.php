<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Http\Request\Api\Private\UserProfilePostRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function getUser($userid)
    {

        $user = User::find($userid);
        if (! isset($user)) {
            return response()->json(['msg' => trans('shared.failed')], 422);
        }

        return response()->json([
            'msg' => trans('shared.success'),
            'user' => $user], 200);
    }

    public function postUser(UserProfilePostRequest $request, $userid)
    {
        // Validation
        $user = User::find($userid);

        if (isset($user)) {

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->birthday = $request->birthday;
            $user->gender = $request->gender;

            $user->save();

            return response()->json(['msg' => trans('shared.success')], 200);

        }

        return response()->json(['msg' => trans('shared.failed')], 422);

    }
}
