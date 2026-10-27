<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Services\Admin\BlogsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogsController extends BaseController
{
    public function __construct(protected BlogsService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:blog.read')->only(['index']);
        $this->middleware('can:blog.create')->only(['create', 'store']);
        $this->middleware('can:blog.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:blog.delete')->only('destroy');
    }

    public function index(Request $request){
        $filters = $request->only('status', 'category_id', 'search');
        
        return view('admin.blogs.index', [
            'blogs' => $this->service->getBlogs($filters),
            'filters' => $filters,
            'categories' => Category::where('status', true)->orderBy('order_level')->get(),
        ]);
    }

    public function create(){
        return view('admin.blogs.form', [
            'categories' => Category::where('status', true)->orderBy('order_level')->get(),
        ]);
    }

    public function store(BlogRequest $request): JsonResponse
    {
        $blog = $this->service->storeBlog($request->validated());
        return $this->successJson('Blog created successfully!', $blog, 201);
    }

    public function edit(Blog $blog){
        return view('admin.blogs.form', [
            'blog' => $blog,
            'categories' => Category::where('status', true)->orderBy('order_level')->get(),
        ]);
    }

    public function update(BlogRequest $request, Blog $blog): JsonResponse
    {
        $updated = $this->service->updateBlog($blog->id, $request->validated());
        return $this->successJson('Blog updated successfully!', $updated);
    }

    public function destroy(Blog $blog){
        $this->service->deleteBlog($blog->id);
        return redirect()->back()->with('success', 'Blog deleted permanently!');
    }

    public function toggleStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:blogs,id']);
        $newStatus = $this->service->toggleStatus((int) $request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:blogs,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel((int) $request->id, (int) $request->order_level);
        return $this->successJson('Order updated!');
    }
}