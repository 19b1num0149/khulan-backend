<?php

namespace App\Http\Controllers\Group;

use App\Events\Group\ItemSaved;
use App\Http\Controllers\Controller;
use App\Http\Request\Group\StoreGroupRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class GroupController extends Controller
{
    public function index(Request $request): Response
    {
        $data = Group::orderBy('id', 'DESC')->paginate(50)->withQueryString();

        return Inertia::render('group/index', [
            'data' => $data,
        ]);
    }

    public function create(): Response
    {
        $users = User::orderBy('name', 'ASC')->get();

        return Inertia::render('group/create', [
            'users' => $users,
        ]);
    }

    public function store(StoreGroupRequest $request)
    {
        $item = new Group;
        $item->name = $request->name;
        $item->founded_year = $request->founded_year;
        $item->description = $request->description;
        $item->user_id = $request->admin;
        $item->qr_data = null;
        $item->save();

        ItemSaved::dispatch($item);

        //return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

        return to_route('item.show', $item->id);
    }

    public function show(Request $request, $id): Response
    {   
        $data = Group::with('user')->findOrFail($id);
        return Inertia::render('group/show', [
            'data' => $data,
        ]);
    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }

        $group = Group::with('user')->findOrFail($id);
        $users = User::orderBy('name', 'ASC')->get();

        return Inertia::render('group/edit', [
            'users' => $users,
            'group' => $group,
            'prev' => $prev
        ]);
    }

    public function update(StoreGroupRequest $request, $id)
    {
        $item = Group::findOrFail($id);
        $item->name = $request->name;
        $item->founded_year = $request->founded_year;
        $item->description = $request->description;
        $item->user_id = $request->admin['id'];
        $item->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]
        );
    }

    public function destroy(Request $request, $id)
    {
        Group::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}