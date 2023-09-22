<?php

namespace App\Http\Controllers\Company\Temple;

use App\Events\Temple\ItemSaved;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Temple\StoreItemRequest;
use App\Models\Temple\TempleQrCategory;
use App\Models\Temple\TempleQrItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QrItemController extends Controller
{
    public function index(Request $request): Response
    {
        $data = TempleQrItem::filterName($request->search)->orderBy('id', 'DESC')->paginate(50)->withQueryString();

        return Inertia::render('company/temple/item/index', ['listdata' => $data,
            'types' => config('temple.types'),
            'filters' => $request->only('search')]);
    }

    public function create(): Response
    {
        $categories = TempleQrCategory::orderBy('name', 'ASC')->get();

        return Inertia::render('company/temple/item/create', [
            'types' => config('temple.types'),
            'categories' => $categories,
        ]);
    }

    public function store(StoreItemRequest $request)
    {
        $item = new TempleQrItem;
        $item->code = $request->code;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->category_id = $request->category;
        $item->type = $request->type;
        if ($request->hasFile('image') && $request->has('image')) {
            $item->image = $request->image->store('temple');
        }
        $item->made_at = $request->madeAt;
        $item->company_built = $request->companyBuilt;
        $item->company_built_basement = $request->companyBuiltBasement;
        $item->company_designed = $request->designDesc;
        $item->company_id = $request->user()->company_id;
        $item->user_id = $request->user()->id;
        $item->save();

        // Dispatching Event
        ItemSaved::dispatch($item);

        //return redirect()->back()->with(['success' => trans('shared.saved_successfully')]);

        return to_route('item.show', $item->id);
    }

    public function show(Request $request, $id): Response
    {
        $item = TempleQrItem::with('categories')->findOrFail($id);

        return Inertia::render('company/temple/item/show', [
            'types' => config('temple.types'),
            'item' => $item,
            'listtypes' => config('temple.people_types'),
        ]);
    }

    public function edit(Request $request, $id): Response
    {
        $prev = url()->previous();
        if ($request->session()->has('prev')) {
            $prev = $request->session()->pull('prev');
        }
        $category = TempleQrItem::findOrFail($id);

        return Inertia::render('company/temple/item/edit', ['category' => $category,
            'types' => config('temple.types'),
            'prev' => $prev]);
    }

    public function update(StoreItemRequest $request, $id)
    {
        $category = TempleQrItem::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->type = $request->type;
        $category->company_id = $request->user()->company_id;
        $category->save();

        return redirect()->back()->with(['success' => trans('shared.updated_successfully'),
            'prev' => $request->_prev]);

    }

    public function destroy(Request $request, $id)
    {
        TempleQrItem::destroy($id);

        return redirect()->back()->with(['success' => trans('shared.deleted_successfully')]);
    }
}
