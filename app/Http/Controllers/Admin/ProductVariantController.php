<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductVariantRequest;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Services\Admin\ProductVariantService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProductVariantController extends BaseController
{
    public function __construct(protected ProductVariantService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:product.update');
    }

    public function index(Product $product): View
    {
        return view('ecom.products.variants', [
            'product' => $product,
            'variants' => $this->service->getVariants($product->id),
            'attributes' => ProductAttribute::active()->ordered()->get(),
        ]);
    }

    public function store(ProductVariantRequest $request, Product $product): JsonResponse
    {
        $variant = $this->service->storeVariant($product->id, $request->validated());
        return $this->successJson('Variant created successfully!', $variant, 201);
    }

    public function update(ProductVariantRequest $request, ProductVariant $variant): JsonResponse
    {
        $updated = $this->service->updateVariant($variant->id, $request->validated());
        return $this->successJson('Variant updated successfully!', $updated);
    }

    public function destroy(ProductVariant $variant): JsonResponse
    {
        $this->service->delete($variant->id);
        return $this->successJson('Variant deleted successfully!');
    }
}