<?php

namespace App\Http\Controllers\Company\Hr;

use App\Http\Controllers\Controller;
use App\Models\Hr\HrCustomer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HrCustomerController extends Controller
{
    public function index(Request $request): Response
    {
        $data = HrCustomer::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('company/hr/customer/index', [
            'listdata' => $data,
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('company/hr/customer/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $customer = new HrCustomer;
        $customer->name = $request->name;
        $customer->contact_person = $request->contact_person;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->description = $request->description;
        $customer->company_id = $request->user()->company_id;
        $customer->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $customer = HrCustomer::findOrFail($id);

        return Inertia::render('company/hr/customer/edit', [
            'customer' => $customer,
            'prev' => $prev,
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $customer = HrCustomer::findOrFail($id);
        $customer->name = $request->name;
        $customer->contact_person = $request->contact_person;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->description = $request->description;
        $customer->company_id = $request->user()->company_id;
        $customer->save();

        return redirect()->back()->with([
            'success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev,
        ]);

    }

    public function destroy(Request $request, $id)
    {
        HrCustomer::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
