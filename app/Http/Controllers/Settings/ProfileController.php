<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(Request $request, $id): Response
    {
        $user = User::find($id);

        return Inertia::render('settings/profile/index', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'password' => ['nullable', 'max:255'],
        ],
            [
                'name.required' => trans('form.required'),
                'name.max' => trans('form.max', ['max' => 255]),
                'password.required' => trans('form.required'),
                'password.max' => trans('form.max', ['max' => 255]),
            ]);

        $user = User::find($id);
        $user->name = $request->name;
        if ($request->has('password') && strlen($request->password) > 1) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully')]);

    }
}
