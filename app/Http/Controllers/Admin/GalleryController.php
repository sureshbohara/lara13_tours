<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GalleryRequest;
use App\Models\Gallery;
use App\Services\Admin\GalleryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends BaseController
{
    public function __construct(protected GalleryService $service) 
    {
        $this->middleware('auth:admin');
        $this->middleware('can:gallery.read')->only(['index']);
        $this->middleware('can:gallery.create')->only(['create', 'store']);
        $this->middleware('can:gallery.update')->only(['edit', 'update', 'galleryStatus', 'updateOrderLevel']);
        $this->middleware('can:gallery.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        return view('admin.gallery.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.form');
    }

    public function store(GalleryRequest $request): JsonResponse
    {
        $item = $this->service->store($request->validated());

        return $this->successJson('Gallery item created successfully!', $item, 201);
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.form', compact('gallery'));
    }

    public function update(GalleryRequest $request, Gallery $gallery): JsonResponse
    {
        $updated = $this->service->update($gallery->id, $request->validated());

        return $this->successJson('Gallery item updated successfully!', $updated);
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->service->delete($gallery->id);

        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function galleryStatus(Request $request): JsonResponse
    {
        $request->validate([
            'status_id' => ['required', 'integer', 'exists:galleries,id'],
        ]);

        $newStatus = $this->service->toggleStatus((int) $request->status_id);

        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => ['required', 'integer', 'exists:galleries,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);

        $this->service->updateOrderLevel(
            (int) $request->id,
            (int) $request->order_level
        );

        return $this->successJson('Order updated!');
    }
}