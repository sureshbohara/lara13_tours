<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use App\Services\Admin\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends BaseController
{
    public function __construct(protected BrandService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:brand.read')->only(['index']);
        $this->middleware('can:brand.create')->only(['create', 'store']);
        $this->middleware('can:brand.update')->only(['edit', 'update', 'brandStatus', 'updateOrderLevel']);
        $this->middleware('can:brand.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'search');

        return view('ecom.brands.index', [
            'brands'  => $this->service->getItems($filters),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('ecom.brands.form');
    }

    public function store(BrandRequest $request): JsonResponse
    {
        $brand = $this->service->storeBrand($request->validated());
        return $this->successJson('Brand created successfully!', $brand, 201);
    }



    public function edit(Brand $brand): View
    {
        return view('ecom.brands.form', compact('brand'));
    }



    public function update(BrandRequest $request, Brand $brand): JsonResponse
    {
        $updated = $this->service->updateBrand($brand->id, $request->validated());
        return $this->successJson('Brand updated successfully!', $updated);
    }



    public function destroy(Brand $brand): RedirectResponse
    {
        $this->service->delete($brand->id);
        return redirect()->back()->with('success', 'Brand deleted permanently!');
    }


    public function brandStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status_id' => ['required', 'integer', 'exists:brands,id'],
        ]);

        $newStatus = $this->service->toggleStatus((int) $validated['status_id']);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }


    public function updateOrderLevel(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id'          => ['required', 'integer', 'exists:brands,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);

        $this->service->updateOrderLevel((int) $validated['id'], (int) $validated['order_level']);
        return $this->successJson('Order updated!');
    }
}