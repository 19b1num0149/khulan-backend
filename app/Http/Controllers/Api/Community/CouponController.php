<?php

namespace app\Http\Controllers\Api\Community;

use App\Http\Controllers\Controller;
use App\Models\GroupMemberCoupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function getCoupons(Request $request)
    {
        $coupons = GroupMemberCoupon::select('id', 'group_id', 'member_id', 'description')
            ->where('group_id', $request->group_id)
            ->with('group:id,name')
            ->with('member:id,name')
            ->paginate(15);

        $transformedCoupons = [];

        foreach ($coupons as $coupons) {
            $transformedCoupons[] = [
                'id' => $coupons->id,
                'group' => $coupons->group,
                'member' => $coupons->member,
                'description' => $coupons->description,
            ];
        }

        return response()->json(['coupons' => $transformedCoupons], 200);
    }
}
