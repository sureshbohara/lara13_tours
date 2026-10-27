<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Services\Admin\BannerService;
use Illuminate\Http\Request;

class BannerController extends BaseController
{
    public function __construct(protected BannerService $service)
    {
       
    }

    public function index(Request $request){
        return view('admin.banner.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create()
    {
        return view('admin.banner.form');
    }

    public function store(BannerRequest $request)
    {
        $item = $this->service->store($request->validated());
        return $this->successJson('Banner created successfully!', $item, 201);
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.form', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $updated = $this->service->update($banner->id, $request->validated());
        return $this->successJson('Banner updated successfully!', $updated);
    }

    public function destroy(Banner $banner)
    {
        $this->service->delete($banner->id);
        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function bannerStatus(Request $request)
    {
        $request->validate(['status_id' => 'required|exists:banners,id']);
        $newStatus = $this->service->toggleStatus((int) $request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:banners,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel((int) $request->id, (int) $request->order_level);
        return $this->successJson('Order updated!');
    }
}