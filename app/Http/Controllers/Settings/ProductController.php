<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $data = Product::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('settings/product/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        return Inertia::render('settings/product/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $product = Product::findOrFail($id);

        return Inertia::render('settings/product/edit', ['product' => $product,
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

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        Product::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
