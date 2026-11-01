<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use App\Services\Admin\PageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends BaseController
{
    public function __construct(protected PageService $service) 
    {
        $this->middleware('auth:admin');
        $this->middleware('can:page.read')->only(['index']);
        $this->middleware('can:page.create')->only(['create', 'store']);
        $this->middleware('can:page.update')->only(['edit', 'update', 'pageStatus', 'updateOrderLevel']);
        $this->middleware('can:page.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        return view('admin.page.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.page.form');
    }

    public function store(PageRequest $request): JsonResponse
    {
        $item = $this->service->store($request->validated());

        return $this->successJson('Page created successfully!', $item, 201);
    }

    public function edit(Page $page): View
    {
        return view('admin.page.form', compact('page'));
    }

    public function update(PageRequest $request, Page $page): JsonResponse
    {
        $updated = $this->service->update($page->id, $request->validated());

        return $this->successJson('Page updated successfully!', $updated);
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->service->delete($page->id);

        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function pageStatus(Request $request): JsonResponse
    {
        $request->validate([
            'status_id' => ['required', 'integer', 'exists:pages,id'],
        ]);

        $newStatus = $this->service->toggleStatus((int) $request->status_id);

        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => ['required', 'integer', 'exists:pages,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);

        $this->service->updateOrderLevel(
            (int) $request->id,
            (int) $request->order_level
        );

        return $this->successJson('Order updated!');
    }
}