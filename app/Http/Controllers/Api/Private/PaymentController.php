<?php

namespace App\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getData(Request $request)
    {

        $data = Invoice::where('user_id', $request->user()->id)
            ->orderBy('id', 'DESC')
            ->simplepaginate(15);

        return response()->json(['msg' => 'success', 'data' => $data], 200);

    }

    public function view($id)
    {

        $data = Invoice::find($id);

        return response()->json(['msg' => 'success', 'data' => $data], 200);

    }
}
