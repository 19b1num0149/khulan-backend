<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function index(Request $request): Response
    {
        $data = Company::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('settings/company/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        return Inertia::render('settings/company/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $company = new Company;
        $company->name = $request->name;
        $company->description = $request->description;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $company = Company::findOrFail($id);

        return Inertia::render('settings/company/edit', ['company' => $company,
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

        $company = Company::findOrFail($id);
        $company->name = $request->name;
        $company->description = $request->description;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function show(Request $request, $id): Response
    {
        $company = Company::with(['products.product'])->findOrFail($id);
        $products = Product::orderBy('name', 'ASC')->get();

        return Inertia::render('settings/company/show', ['company' => $company,
            'listproduct' => $products]);
    }

    public function destroy(Request $request, $id)
    {
        Company::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
