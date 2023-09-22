<?php

namespace App\Http\Controllers\Company\Temple;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Temple\StoreItemPersonRequest;
use App\Models\Temple\TempleQrItemPerson;
use Illuminate\Http\Request;

class QrItemPersonController extends Controller
{
    public function index(Request $request)
    {
        $data = TempleQrItemPerson::FilterName($request->search)
            ->where('item_id', $request->item)
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json(['people' => $data], 200);
    }

    public function store(StoreItemPersonRequest $request, $itemid)
    {
        $person = new TempleQrItemPerson;
        $person->item_id = $itemid;
        $person->family_name = $request->family_name;
        $person->lastname = $request->lastname;
        $person->firstname = $request->firstname;
        $person->mobile = $request->mobile;
        $person->email = $request->email;
        $person->type = $request->type;
        $person->save();

        return response()->json(['success' => trans('shared.saved_successfully')], 200);
    }

    public function update(StoreItemPersonRequest $request, $itemid, $id)
    {
        $person = TempleQrItemPerson::find($id);
        $person->item_id = $itemid;
        $person->family_name = $request->family_name;
        $person->lastname = $request->lastname;
        $person->firstname = $request->firstname;
        $person->mobile = $request->mobile;
        $person->email = $request->email;
        $person->type = $request->type;
        $person->save();

        return response()->json(['success' => trans('shared.updated_successfully')], 200);

    }

    public function destroy(Request $request, $itemid, $id)
    {
        TempleQrItemPerson::destroy($id);

        return response()->json(['success' => trans('shared.deleted_successfully')], 200);
    }
}
