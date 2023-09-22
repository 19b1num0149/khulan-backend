<?php

namespace App\Http\Controllers\Company\Temple;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Temple\StoreCategoryRequest;
use App\Models\Temple\TempleQrCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QrCategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $data = TempleQrCategory::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('company/temple/category/index', ['listdata' => $data,
            'types' => config('temple.types'),
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        return Inertia::render('company/temple/category/create', [
            'types' => config('temple.types'),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = new TempleQrCategory;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->type = $request->type;
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
        $category = TempleQrCategory::findOrFail($id);

        return Inertia::render('company/temple/category/edit', ['category' => $category,
            'types' => config('temple.types'),
            'prev' => $prev]);
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $category = TempleQrCategory::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->type = $request->type;
        $category->company_id = $request->user()->company_id;
        $category->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        TempleQrCategory::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
