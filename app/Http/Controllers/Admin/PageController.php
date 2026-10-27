<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use App\Services\Admin\PageService;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    public function __construct(protected PageService $service) {}

    public function index(Request $request)
    {
        return view('admin.page.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create()
    {
        return view('admin.page.form');
    }

    public function store(PageRequest $request)
    {
        $item = $this->service->store($request->validated());
        return $this->successJson('Page created successfully!', $item, 201);
    }

    public function edit(Page $page)
    {
        return view('admin.page.form', compact('page'));
    }

    public function update(PageRequest $request, Page $page)
    {
        $updated = $this->service->update($page->id, $request->validated());
        return $this->successJson('Page updated successfully!', $updated);
    }

    public function destroy(Page $page)
    {
        $this->service->delete($page->id);
        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function pageStatus(Request $request)
    {
        $request->validate(['status_id' => 'required|exists:pages,id']);
        $newStatus = $this->service->toggleStatus((int) $request->status_id);
        
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:pages,id',
            'order_level' => 'required|integer|min:0',
        ]);
        
        $this->service->updateOrderLevel((int) $request->id, (int) $request->order_level);
        return $this->successJson('Order updated!');
    }
}