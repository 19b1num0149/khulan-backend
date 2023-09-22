<?php

namespace App\Http\Controllers\Company\Hr;

use App\Http\Controllers\Controller;
use App\Models\Hr\HrCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HrCategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $data = HrCategory::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('company/hr/category/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        return Inertia::render('company/hr/category/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $category = new HrCategory;
        $category->name = $request->name;
        $category->company_id = $request->user()->company_id;
        $category->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $category = HrCategory::findOrFail($id);

        return Inertia::render('company/hr/category/edit', ['category' => $category,
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

        $category = HrCategory::findOrFail($id);
        $category->name = $request->name;
        $category->company_id = $request->user()->company_id;
        $category->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        HrCategory::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
