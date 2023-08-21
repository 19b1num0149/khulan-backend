<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Http\Request\Api\Private\UserProfilePostRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function getUser($userid)
    {

        $user = User::find($id);
        if (! isset($user)) {
            return response()->json(['msg' => 'User not found'], 404);
        }

        return response()->json(['msg' => 'Success', 'data' => $user], 200);
    }

    public function postUser(UserProfilePostRequest $request, $userid)
    {
        // Validation
        $user = User::find($userid);

        if (isset($user)) {

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();

            return respose()->json(['msg' => trans('shared.success')], 200);

        }

        return respose()->json(['msg' => trans('shared.failed')], 422);

        // // $data = $request->validate([
        // //     'name' => 'required|string',
        // //     'email' => 'required|email|unique:users',
        // //     'phone' => 'required|string|unique:users',
        // //     'address' => 'nullable|string',
        // //     'age' => 'nullable|integer|min:0',
        // //     'gender' => 'nullable|in:male,female,other',
        // // ]);

        // $user->update($data);

        // return response()->json(['msg' => 'success', 'data' => $user], 200);
    }
}
