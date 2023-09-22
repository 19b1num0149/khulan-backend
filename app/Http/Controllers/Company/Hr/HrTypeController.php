<?php

namespace App\Http\Controllers\Company\Hr;

use App\Http\Controllers\Controller;
use App\Models\Hr\HrType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HrTypeController extends Controller
{
    public function index(Request $request): Response
    {
        $data = HrType::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('company/hr/type/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        return Inertia::render('company/hr/type/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $type = new HrType;
        $type->name = $request->name;
        $type->company_id = $request->user()->company_id;
        $type->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $type = HrType::findOrFail($id);

        return Inertia::render('company/hr/type/edit', ['type' => $type,
            'prev' => $prev]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $type = HrType::findOrFail($id);
        $type->name = $request->name;
        $type->company_id = $request->user()->company_id;
        $type->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        HrType::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
