<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends BaseController
{
    public function __construct(protected ProductService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:product.read')->only(['index']);
        $this->middleware('can:product.create')->only(['create', 'store']);
        $this->middleware('can:product.update')->only(['edit', 'update', 'productStatus', 'productFeatured', 'updateOrderLevel', 'deleteGalleryImage']);
        $this->middleware('can:product.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'product_type', 'brand_id', 'search');

        return view('ecom.products.index', [
            'products' => $this->service->getItems($filters),
            'filters'  => $filters,
            'brands'   => Brand::active()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('ecom.products.form', [
            'categories' => Category::whereNull('parent_id')->with('children')->ordered()->get(),
            'brands' => Brand::active()->ordered()->get(),
            'allProducts' => Product::active()->orderBy('name')->get(),
        ]);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->service->storeProduct($request->validated());
        return $this->successJson('Product created successfully!', $product, 201);
    }

    public function edit(Product $product): View
    {
        return view('ecom.products.form', [
            'product' => $product,
            'categories' => Category::whereNull('parent_id')->with('children')->ordered()->get(),
            'brands' => Brand::active()->ordered()->get(),
            'allProducts' => Product::active()->where('id', '!=', $product->id)->orderBy('name')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $updated = $this->service->updateProduct($product->id, $request->validated());
        return $this->successJson('Product updated successfully!', $updated);
    }


    public function destroy(Product $product): RedirectResponse
    {
        $this->service->delete($product->id);
        return redirect()->back()->with('success', 'Product deleted permanently!');
    }


    public function productStatus(Request $request): JsonResponse
    {
        $validated = $request->validate(['status_id' => ['required', 'integer', 'exists:products,id']]);
        $newStatus = $this->service->toggleStatus((int) $validated['status_id']);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }


    public function productFeatured(Request $request): JsonResponse
    {
        $validated = $request->validate(['status_id' => ['required', 'integer', 'exists:products,id']]);
        $newStatus = $this->service->toggleFeatured((int) $validated['status_id']);
        return $this->successJson('Featured status updated', ['new_status' => $newStatus]);
    }


    public function updateOrderLevel(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:products,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);
        $this->service->updateOrderLevel((int) $validated['id'], (int) $validated['order_level']);
        return $this->successJson('Order updated!');
    }


    public function deleteGalleryImage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:products,id'],
            'image' => ['required', 'string'],
        ]);
        $this->service->deleteGalleryImage((int) $validated['id'], $validated['image']);
        return $this->successJson('Gallery image deleted successfully!');
    }
    
}