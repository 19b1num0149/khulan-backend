<?php

namespace App\Http\Controllers\Company\Hr;

use App\Http\Controllers\Controller;
use App\Models\Hr\HrJobType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HrJobTypeController extends Controller
{
    public function index(Request $request): Response
    {
        $data = HrJobType::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('company/hr/jobtype/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        return Inertia::render('company/hr/jobtype/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $jobtype = new HrJobType;
        $jobtype->name = $request->name;
        $jobtype->company_id = $request->user()->company_id;
        $jobtype->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $jobtype = HrJobType::findOrFail($id);

        return Inertia::render('company/hr/jobtype/edit', ['jobtype' => $jobtype,
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

        $jobtype = HrJobType::findOrFail($id);
        $jobtype->name = $request->name;
        $jobtype->company_id = $request->user()->company_id;
        $jobtype->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        HrJobType::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
