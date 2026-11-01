<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ReviewRequest;
use App\Models\Review;
use App\Services\Admin\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends BaseController
{
    public function __construct(protected ReviewService $service) 
    {
        $this->middleware('auth:admin');
        $this->middleware('can:review.read')->only(['index']);
        $this->middleware('can:review.create')->only(['create', 'store']);
        $this->middleware('can:review.update')->only(['edit', 'update', 'reviewStatus', 'updateOrderLevel']);
        $this->middleware('can:review.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        return view('admin.review.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.review.form');
    }

    public function store(ReviewRequest $request): JsonResponse
    {
        $item = $this->service->store($request->validated());

        return $this->successJson('Review created successfully!', $item, 201);
    }

    public function edit(Review $review): View
    {
        return view('admin.review.form', compact('review'));
    }

    public function update(ReviewRequest $request, Review $review): JsonResponse
    {
        $updated = $this->service->update($review->id, $request->validated());

        return $this->successJson('Review updated successfully!', $updated);
    }

    public function destroy(Review $review): RedirectResponse
    {
        $this->service->delete($review->id);

        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function reviewStatus(Request $request): JsonResponse
    {
        $request->validate([
            'status_id' => ['required', 'integer', 'exists:reviews,id'],
        ]);

        $newStatus = $this->service->toggleStatus((int) $request->status_id);

        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => ['required', 'integer', 'exists:reviews,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);

        $this->service->updateOrderLevel(
            (int) $request->id,
            (int) $request->order_level
        );

        return $this->successJson('Order updated!');
    }
}