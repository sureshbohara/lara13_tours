<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Services\Admin\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends BaseController
{
    public function __construct(protected BannerService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:banner.read')->only(['index']);
        $this->middleware('can:banner.create')->only(['create', 'store']);
        $this->middleware('can:banner.update')->only(['edit', 'update', 'bannerStatus', 'updateOrderLevel']);
        $this->middleware('can:banner.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'search');

        return view('admin.banner.index', [
            'items'   => $this->service->getItems($filters),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.banner.form');
    }

    public function store(BannerRequest $request): JsonResponse
    {
        $banner = $this->service->store($request->validated());

        return $this->successJson('Banner created successfully!', $banner, 201);
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banner.form', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner): JsonResponse
    {
        $updated = $this->service->update($banner->id, $request->validated());

        return $this->successJson('Banner updated successfully!', $updated);
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->service->delete($banner->id);

        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function bannerStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status_id' => ['required', 'integer', 'exists:banners,id'],
        ]);

        $newStatus = $this->service->toggleStatus((int) $validated['status_id']);

        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id'          => ['required', 'integer', 'exists:banners,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);

        $this->service->updateOrderLevel(
            (int) $validated['id'],
            (int) $validated['order_level']
        );

        return $this->successJson('Order updated!');
    }
}