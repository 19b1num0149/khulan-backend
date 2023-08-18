<?php

namespace App\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller{

    public function getData(Request $request , $contentid) {

        $data = Content::find($contentid);
        return response()->json(['msg' => 'success' , 'data' => $data] , 200);

    }

}