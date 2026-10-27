<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GalleryRequest;
use App\Models\Gallery;
use App\Services\Admin\GalleryService;
use Illuminate\Http\Request;

class GalleryController extends BaseController
{
    public function __construct(protected GalleryService $service) {}

    public function index(Request $request)
    {
        return view('admin.gallery.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create()
    {
        return view('admin.gallery.form');
    }

    public function store(GalleryRequest $request)
    {
        $item = $this->service->store($request->validated());
        return $this->successJson('Gallery item created successfully!', $item, 201);
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.form', compact('gallery'));
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $updated = $this->service->update($gallery->id, $request->validated());
        return $this->successJson('Gallery item updated successfully!', $updated);
    }

    public function destroy(Gallery $gallery)
    {
        $this->service->delete($gallery->id);
        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function galleryStatus(Request $request)
    {
        $request->validate(['status_id' => 'required|exists:galleries,id']);
        $newStatus = $this->service->toggleStatus((int) $request->status_id);
        
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:galleries,id',
            'order_level' => 'required|integer|min:0',
        ]);
        
        $this->service->updateOrderLevel((int) $request->id, (int) $request->order_level);
        return $this->successJson('Order updated!');
    }
}