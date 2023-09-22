<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\CompanyProduct;
use Illuminate\Http\Request;

class CompanyProductController extends Controller
{
    public function index(Request $request, $id)
    {
        $products = CompanyProduct::with(['product'])
            ->where('company_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(['products' => $products], 200);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'product' => ['required'],
            'started' => ['required', 'date'],
            'ended' => ['nullable', 'date'],
        ], [
            'product.required' => trans('form.required'),
            'started.required' => trans('form.required'),
            'started.date' => trans('form.date'),
            'ended.date' => trans('form.date'),
        ]);

        $product = new CompanyProduct;
        $product->company_id = $request->companyid;
        $product->product_id = $request->product;
        $product->started_at = $request->started;
        $product->ended_at = $request->ended;
        $product->description = $request->description;
        $product->save();

        return response()->json(['success' => trans('shared.saved_successfully')], 200);
    }

    public function edit(Request $request, $id, $productid)
    {
        $product = CompanyProduct::find($productid);

        return response()->json(['product' => $product], 200);
    }

    public function update(Request $request, $id, $productid)
    {
        $request->validate([
            'product' => ['required'],
            'started' => ['required', 'date'],
            'ended' => ['nullable', 'date'],
        ], [
            'product.required' => trans('form.required'),
            'started.required' => trans('form.required'),
            'started.date' => trans('form.date'),
            'ended.date' => trans('form.date'),
        ]);

        $product = CompanyProduct::find($productid);
        $product->company_id = $request->companyid;
        $product->product_id = $request->product;
        $product->started_at = $request->started;
        $product->ended_at = $request->ended;
        $product->description = $request->description;
        $product->save();

        return response()->json(['success' => trans('shared.updated_successfully')], 200);
    }

    public function destroy(Request $request, $id, $productid)
    {
        CompanyProduct::destroy($productid);

        return response()->json(['success' => trans('shared.deleted_successfully')], 200);
    }
}
