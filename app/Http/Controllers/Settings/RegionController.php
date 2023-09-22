<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RegionController extends Controller
{
    public function index(Request $request): Response
    {
        $data = Region::with(['country'])->filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('settings/region/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        $countries = Country::orderBy('name', 'ASC')->get();

        return Inertia::render('settings/region/create', ['countries' => $countries]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'country' => 'required',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'country.required' => trans('form.required'),
        ]);

        $region = new Region;
        $region->name = $request->name;
        $region->country_id = $request->country;
        $region->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $region = Region::findOrFail($id);
        $countries = Country::orderBy('name', 'ASC')->get();

        return Inertia::render('settings/region/edit', ['region' => $region,
            'countries' => $countries,
            'prev' => $prev]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:255',
            'country' => 'required',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'country.required' => trans('form.required'),
        ]);

        $region = Region::findOrFail($id);
        $region->name = $request->name;
        $region->country_id = $request->country;
        $region->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        Region::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
