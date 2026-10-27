<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use App\Services\Admin\FaqService;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    public function __construct(protected FaqService $service) {}

    public function index(Request $request)
    {
        return view('admin.faqs.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create()
    {
        return view('admin.faqs.form');
    }

    public function store(FaqRequest $request)
    {
        $item = $this->service->store($request->validated());
        return $this->successJson('FAQ created successfully!', $item, 201);
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $updated = $this->service->update($faq->id, $request->validated());
        return $this->successJson('FAQ updated successfully!', $updated);
    }

    public function destroy(Faq $faq)
    {
        $this->service->delete($faq->id);
        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function faqStatus(Request $request)
    {
        $request->validate(['status_id' => 'required|exists:faqs,id']);
        $newStatus = $this->service->toggleStatus((int) $request->status_id);
        
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:faqs,id',
            'order_level' => 'required|integer|min:0',
        ]);
        
        $this->service->updateOrderLevel((int) $request->id, (int) $request->order_level);
        return $this->successJson('Order updated!');
    }
}