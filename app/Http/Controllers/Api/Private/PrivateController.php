<?php
namespace app\Http\Controllers\Api\Private;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PrivateController extends Controller
{
    public function getUser($id){

        $user = User::find($id);
        if (!isset($user)) {
            return response()->json(['msg' => 'User not found'], 404);
        }
        return response()->json(['msg' => 'Success' , 'data' => $user], 200);

    }
}
 