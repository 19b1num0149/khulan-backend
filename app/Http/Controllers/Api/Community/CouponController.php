<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\GroupMemberCoupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function getCoupons(Request $request)
    {
        $group_id = $request->group_id;

        $coupons = GroupMemberCoupon::with(['group:id,name', 'member:id,name'])
            ->select('id', 'group_id', 'member_id', 'description')
            ->where('group_id', $group_id)
            ->simplePaginate(15);

        return response()->json(['coupons' => $coupons], 200);
    }
}
