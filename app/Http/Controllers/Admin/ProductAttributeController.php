<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductAttributeRequest;
use App\Models\ProductAttribute;
use App\Services\Admin\ProductAttributeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductAttributeController extends BaseController
{
    public function __construct(protected ProductAttributeService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:product-attribute.read')->only(['index']);
        $this->middleware('can:product-attribute.create')->only(['create', 'store']);
        $this->middleware('can:product-attribute.update')->only(['edit', 'update', 'attributeStatus', 'updateOrderLevel']);
        $this->middleware('can:product-attribute.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'search');

        return view('ecom.product_attributes.index', [
            'attributes' => $this->service->getItems($filters),
            'filters'    => $filters,
        ]);
    }

    public function create(): View
    {
        return view('ecom.product_attributes.form');
    }

    public function store(ProductAttributeRequest $request): JsonResponse
    {
        $attribute = $this->service->storeAttribute($request->validated());
        return $this->successJson('Attribute created successfully!', $attribute, 201);
    }

    public function edit(ProductAttribute $productAttribute): View
    {
        return view('ecom.product_attributes.form', compact('productAttribute'));
    }

    public function update(ProductAttributeRequest $request, ProductAttribute $productAttribute): JsonResponse
    {
        $updated = $this->service->updateAttribute($productAttribute->id, $request->validated());
        return $this->successJson('Attribute updated successfully!', $updated);
    }

    public function destroy(ProductAttribute $productAttribute): RedirectResponse
    {
        $this->service->delete($productAttribute->id);
        return redirect()->back()->with('success', 'Attribute deleted permanently!');
    }

    public function attributeStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status_id' => ['required', 'integer', 'exists:product_attributes,id'],
        ]);
        $newStatus = $this->service->toggleStatus((int) $validated['status_id']);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id'          => ['required', 'integer', 'exists:product_attributes,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);
        $this->service->updateOrderLevel((int) $validated['id'], (int) $validated['order_level']);
        return $this->successJson('Order updated!');
    }
}