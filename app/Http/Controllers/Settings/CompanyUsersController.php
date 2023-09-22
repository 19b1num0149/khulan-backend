<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyUsersController extends Controller
{
    public function index(Request $request, $id)
    {
        $users = User::where('company_id', $id)
            ->where('type', 'user')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(['users' => $users], 200);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'max:255'],
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'email.required' => trans('form.required'),
            'email.email' => trans('form.email'),
            'email.max' => trans('form.max', ['max' => 255]),
            'email.unique' => trans('form.unique'),
            'password.required' => trans('form.required'),
            'password.max' => trans('form.max', ['max' => 255]),
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = 'user';
        $user->company_id = $request->companyid;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => trans('shared.saved_successfully')], 200);
    }

    public function edit(Request $request, $id, $userid)
    {
        $user = User::find($userid);

        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request, $id, $userid)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'max:255'],
        ], [
            'name.required' => trans('form.required'),
            'name.max' => trans('form.max', ['max' => 255]),
            'email.required' => trans('form.required'),
            'email.email' => trans('form.email'),
            'email.max' => trans('form.max', ['max' => 255]),
            'email.unique' => trans('form.unique'),
            'password.required' => trans('form.required'),
            'password.max' => trans('form.max', ['max' => 255]),
        ]);

        $user = User::find($userid);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password') && strlen($request->password) > 1) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['success' => trans('shared.updated_successfully')], 200);
    }

    public function destroy(Request $request, $id, $userid)
    {
        User::destroy($userid);

        return response()->json(['success' => trans('shared.deleted_successfully')], 200);
    }
}
