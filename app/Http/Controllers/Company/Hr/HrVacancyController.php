<?php

namespace App\Http\Controllers\Company\Hr;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Hr\HrCategory;
use App\Models\Hr\HrCustomer;
use App\Models\Hr\HrJobType;
use App\Models\Hr\HrType;
use App\Models\Hr\HrVacancy;
// use App\Traits\Helper\HasCity;
// use App\Traits\Helper\HasRegion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HrVacancyController extends Controller
{
    // use HasCity, HasRegion;

    public function index(Request $request): Response
    {
        $data = HrVacancy::with(['category', 'type', 'jobtype', 'country', 'region', 'city', 'customer'])
            ->filterName($request->search)
            ->orderBy('id', 'DESC')
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('company/hr/vacancy/index', [
            'listdata' => $data,
            'filters' => $request->only('search'),
        ]);
    }

    public function create(Request $request): Response
    {
        $categories = HrCategory::orderBy('name', 'ASC')->get();
        $types = HrType::orderBy('name', 'ASC')->get();
        $jobtypes = HrJobType::orderBy('name', 'ASC')->get();
        $countries = Country::orderBy('name', 'ASC')->get();
        $customers = HrCustomer::orderBy('name', 'ASC')->get();

        return Inertia::render('company/hr/vacancy/create', [
            'categories' => $categories,
            'types' => $types,
            'jobtypes' => $jobtypes,
            'countries' => $countries,
            'customers' => $customers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'type' => 'required',
            'country' => 'required',
            'salary' => 'nullable|decimal:0,2',
            'description' => 'required',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'category.required' => trans('form.required'),
            'type.required' => trans('form.required'),
            'country.required' => trans('form.required'),
            'salary.decimal' => trans('form.decimal'),
            'description.required' => trans('form.required'),
        ]);

        $vacancy = new HrVacancy;
        $vacancy->name = $request->name;
        $vacancy->duration = $request->duration;
        $vacancy->salary = $request->salary;
        $vacancy->description = $request->description;

        $vacancy->hr_category_id = $request->category;
        $vacancy->hr_type_id = $request->type;
        $vacancy->hr_jobtype_id = $request->jobtype;
        $vacancy->hr_customer_id = $request->customer;

        $vacancy->country_id = $request->country;
        $vacancy->region_id = $request->region;
        $vacancy->city_id = $request->city;

        $vacancy->company_id = $request->user()->company_id;
        $vacancy->user_id = $request->user()->id;
        $vacancy->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }

        $vacancy = HrVacancy::findOrFail($id);
        $categories = HrCategory::orderBy('name', 'ASC')->get();
        $types = HrType::orderBy('name', 'ASC')->get();
        $jobtypes = HrJobType::orderBy('name', 'ASC')->get();
        $countries = Country::orderBy('name', 'ASC')->get();
        $customers = HrCustomer::orderBy('name', 'ASC')->get();

        return Inertia::render('company/hr/vacancy/edit', [
            'vacancy' => $vacancy,
            'categories' => $categories,
            'types' => $types,
            'jobtypes' => $jobtypes,
            'countries' => $countries,
            'customers' => $customers,
            'prev' => $prev,
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'type' => 'required',
            'country' => 'required',
            'salary' => 'nullable|decimal:0,2',
            'description' => 'required',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'category.required' => trans('form.required'),
            'type.required' => trans('form.required'),
            'country.required' => trans('form.required'),
            'salary.decimal' => trans('form.decimal'),
            'description.required' => trans('form.required'),
        ]);

        $vacancy = HrVacancy::findOrFail($id);
        $vacancy->name = $request->name;
        $vacancy->duration = $request->duration;
        $vacancy->salary = $request->salary;
        $vacancy->description = $request->description;

        $vacancy->hr_category_id = $request->category;
        $vacancy->hr_type_id = $request->type;
        $vacancy->hr_jobtype_id = $request->jobtype;
        $vacancy->hr_customer_id = $request->customer;

        $vacancy->country_id = $request->country;
        $vacancy->region_id = $request->region;
        $vacancy->city_id = $request->city;

        $vacancy->company_id = $request->user()->company_id;
        $vacancy->user_id = $request->user()->id;
        $vacancy->save();

        return redirect()->back()->with([
            'success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev,
        ]);

    }

    public function destroy(Request $request, $id)
    {
        HrVacancy::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
