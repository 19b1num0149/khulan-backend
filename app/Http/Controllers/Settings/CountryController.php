<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    public function index(Request $request): Response
    {
        $data = Country::filterName($request->search)->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        return Inertia::render('settings/country/index', ['listdata' => $data,
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        return Inertia::render('settings/country/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
        ]);

        $country = new Country;
        $country->name = $request->name;
        $country->save();

        return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $country = Country::findOrFail($id);

        return Inertia::render('settings/country/edit', ['country' => $country,
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

        $country = Country::findOrFail($id);
        $country->name = $request->name;
        $country->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        Country::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
