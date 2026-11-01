<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponService extends BaseCrudService
{
    public function __construct(Coupon $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, '');
    }

    public function getCoupons(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function storeCoupon(array $data): Coupon
    {
        $data['code'] = strtoupper(trim($data['code']));
        $data['created_by'] = Auth::guard('admin')->id();
        $data['updated_by'] = Auth::guard('admin')->id();
        
        $data['applicable_packages'] = $this->formatApplicablePackages($data['applicable_packages'] ?? null);

        return $this->model->create($data);
    }

    public function updateCoupon(int $id, array $data): Coupon
    {
        $coupon = $this->model->findOrFail($id);
        
        $data['code'] = strtoupper(trim($data['code']));
        $data['updated_by'] = Auth::guard('admin')->id();
        $packages = $data['applicable_packages'] ?? $coupon->applicable_packages;
        $data['applicable_packages'] = $this->formatApplicablePackages($packages);

        $coupon->update($data);
        return $coupon->fresh();
    }


    public function validateCoupon(string $code, float $orderAmount, ?int $packageId = null, ?int $userId = null): array
    {
        $coupon = $this->model->where('code', strtoupper(trim($code)))->first();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Coupon code not found.'];
        }
        if (!$coupon->status) {
            return ['valid' => false, 'message' => 'This coupon is inactive.'];
        }
        if ($coupon->start_date > now()) {
            return ['valid' => false, 'message' => 'This coupon is not yet active.'];
        }
        if ($coupon->end_date && $coupon->end_date < now()) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }
        if ($coupon->min_order_amount && $orderAmount < $coupon->min_order_amount) {
            return [
                'valid' => false, 
                'message' => 'Minimum order amount of $' . number_format((float) $coupon->min_order_amount, 2) . ' required.'
            ];
        }
        if ($coupon->applicable_packages && $packageId && !in_array($packageId, $coupon->applicable_packages)) {
            return ['valid' => false, 'message' => 'This coupon is not valid for this package.'];
        }

        $discount = $this->calculateDiscount($coupon, $orderAmount);

        return [
            'valid' => true,
            'message' => 'Coupon applied successfully!',
            'coupon' => $coupon,
            'discount' => $discount,
            'final_amount' => $orderAmount - $discount,
        ];
    }

    public function calculateDiscount(Coupon $coupon, float $orderAmount): float
    {
        if ($coupon->type === 'percentage') {
            $discount = ($orderAmount * $coupon->value) / 100;
            
            if ($coupon->max_discount && $discount > $coupon->max_discount) {
                $discount = (float) $coupon->max_discount;
            }
        } else {
            $discount = (float) $coupon->value;
        }

        return min($discount, $orderAmount);
    }

    public function incrementUsage(int $couponId): void
    {
        $this->model->findOrFail($couponId)->increment('used_count');
    }

    private function formatApplicablePackages(mixed $packages): ?array
    {
        if (is_array($packages)) {
            $packages = array_filter($packages);
            return empty($packages) ? null : array_values($packages);
        }
        return null;
    }
}