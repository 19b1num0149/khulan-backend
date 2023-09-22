<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Traits\Helper\HasRegion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    use HasRegion;

    public function index(Request $request): Response
    {
        $data = City::with(['region.country'])->filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('settings/city/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(Request $request): Response
    {
        $countries = Country::orderBy('name', 'ASC')->get();

        return Inertia::render('settings/city/create', ['countries' => $countries]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'region' => 'required',
            'country' => 'required',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'region.required' => trans('form.required'),
            'country.required' => trans('form.required'),
        ]);

        $city = new City;
        $city->name = $request->name;
        $city->region_id = $request->region;
        $city->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $city = City::with('region')->findOrFail($id);
        $countries = Country::orderBy('name', 'ASC')->get();

        return Inertia::render('settings/city/edit', ['city' => $city,
            'countries' => $countries,
            'prev' => $prev]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:255',
            'region' => 'required',
            'country' => 'required',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'region.required' => trans('form.required'),
            'country.required' => trans('form.required'),
        ]);

        $city = City::findOrFail($id);
        $city->name = $request->name;
        $city->region_id = $request->region;
        $city->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        City::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
