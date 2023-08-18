<?php

namespace app\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function getUser($id)
    {

        $user = User::find($id);
        if (!isset($user)) {
            return response()->json(['msg' => 'User not found'], 404);
        }
        return response()->json(['msg' => 'Success', 'data' => $user], 200);
    }

    public function postUser(Request $request, $id)
    {
        $user = User::find($id);
    
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'address' => 'nullable|string',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,other',
        ]);
    
        $user->update($data);
    
        return response()->json(['msg' => 'success', 'data' => $user], 200);
    }
}