<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use App\Models\Package;
use App\Services\Admin\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends BaseController
{
    public function __construct(protected CouponService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:coupon.read')->only(['index']);
        $this->middleware('can:coupon.create')->only(['create', 'store']);
        $this->middleware('can:coupon.update')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('can:coupon.delete')->only('destroy');
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'type', 'search');
        $coupons = $this->service->getCoupons($filters);

        return view('admin.coupons.index', compact('coupons', 'filters'));
    }

    public function create(): View
    {
        $packages = Package::active()->ordered()->get(['id', 'name']);
        return view('admin.coupons.form', compact('packages'));
    }

    public function store(CouponRequest $request): JsonResponse
    {
        $coupon = $this->service->storeCoupon($request->validated());
        return $this->successJson('Coupon created successfully!', $coupon, 201);
    }

    public function edit(Coupon $coupon): View
    {
        $packages = Package::active()->ordered()->get(['id', 'name']);
        return view('admin.coupons.form', compact('coupon', 'packages'));
    }

    public function update(CouponRequest $request, Coupon $coupon): JsonResponse
    {
        $updated = $this->service->updateCoupon($coupon->id, $request->validated());
        return $this->successJson('Coupon updated successfully!', $updated);
    }

    public function destroy(Coupon $coupon)
    {
        $this->service->delete($coupon->id);
        return redirect()->back()->with('success', 'Coupon deleted successfully!');
    }

    public function toggleStatus(Request $request): JsonResponse
    {
        $request->validate(['id' => 'required|exists:coupons,id']);
        $newStatus = $this->service->toggleStatus((int) $request->id);
        
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function validateCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'order_amount' => 'required|numeric|min:0',
            'package_id' => 'nullable|integer|exists:packages,id',
        ]);

        $result = $this->service->validateCoupon(
            $request->code,
            (float) $request->order_amount,
            $request->package_id
        );

        return response()->json($result);
    }
}