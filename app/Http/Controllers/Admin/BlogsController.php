<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Services\Admin\BlogsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BlogsController extends BaseController
{
    public function __construct(protected BlogsService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:blog.read')->only(['index']);
        $this->middleware('can:blog.create')->only(['create', 'store']);
        $this->middleware('can:blog.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:blog.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'category_id', 'search');
        return view('admin.blogs.index', [
            'blogs'      => $this->service->getBlogs($filters),
            'filters'    => $filters,
            'categories' => $this->getActiveCategories(),
        ]);
    }


    public function create(): View
    {
        return view('admin.blogs.form', [
            'categories' => $this->getActiveCategories(),
        ]);
    }


    public function store(BlogRequest $request): JsonResponse
    {
        $blog = $this->service->store($request->validated());
        return $this->successJson('Blog created successfully!', $blog, 201);
    }


    public function edit(Blog $blog): View
    {
        return view('admin.blogs.form', [
            'blog'       => $blog,
            'categories' => $this->getActiveCategories(),
        ]);
    }


    public function update(BlogRequest $request, Blog $blog): JsonResponse
    {
        $updated = $this->service->update($blog->id, $request->validated());
        return $this->successJson('Blog updated successfully!', $updated);
    }


    public function destroy(Blog $blog): RedirectResponse
    {
        $this->service->delete($blog->id);
        return redirect()->back()->with('success', 'Blog deleted permanently!');
    }


    public function toggleStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status_id' => ['required', 'integer', 'exists:blogs,id'],
        ]);
        $newStatus = $this->service->toggleStatus((int) $validated['status_id']);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }


    public function updateOrderLevel(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id'          => ['required', 'integer', 'exists:blogs,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);
        $this->service->updateOrderLevel(
            (int) $validated['id'],
            (int) $validated['order_level']
        );
        return $this->successJson('Order updated!');
    }


    private function getActiveCategories(): Collection
    {
        return Category::where('status', true)
            ->orderBy('order_level')
            ->get();
    }
}