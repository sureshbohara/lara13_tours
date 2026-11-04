<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\OfferRequest;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Services\Admin\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfferController extends BaseController
{
    public function __construct(protected OfferService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:offer.read')->only(['index']);
        $this->middleware('can:offer.create')->only(['create', 'store']);
        $this->middleware('can:offer.update')->only(['edit', 'update', 'offerStatus']);
        $this->middleware('can:offer.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'offer_type', 'search');

        return view('ecom.offers.index', [
            'offers' => $this->service->getItems($filters),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('ecom.offers.form', [
            'products' => Product::active()->orderBy('name')->get(),
            'categories' => Category::active()->ordered()->get(),
        ]);
    }

    public function store(OfferRequest $request): JsonResponse
    {
        $offer = $this->service->storeOffer($request->validated());
        return $this->successJson('Offer created successfully!', $offer, 201);
    }

    public function edit(Offer $offer): View
    {
        return view('ecom.offers.form', [
            'offer' => $offer,
            'products' => Product::active()->orderBy('name')->get(),
            'categories' => Category::active()->ordered()->get(),
        ]);
    }

    public function update(OfferRequest $request, Offer $offer): JsonResponse
    {
        $updated = $this->service->updateOffer($offer->id, $request->validated());
        return $this->successJson('Offer updated successfully!', $updated);
    }

    public function destroy(Offer $offer): RedirectResponse
    {
        $this->service->delete($offer->id);
        return redirect()->back()->with('success', 'Offer deleted permanently!');
    }

    public function offerStatus(Request $request): JsonResponse
    {
        $validated = $request->validate(['status_id' => ['required', 'integer', 'exists:offers,id']]);
        $newStatus = $this->service->toggleStatus((int) $validated['status_id']);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }
}