<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    public function getCoupons(array $filters = [])
    {
        return Coupon::getFilteredRecords($filters);
    }

    public function storeCoupon(array $data): Coupon
    {
        $data['code'] = strtoupper(trim($data['code']));
        $data['created_by'] = Auth::guard('admin')->id();
        $data['updated_by'] = Auth::guard('admin')->id();
        

        if (isset($data['applicable_packages']) && is_array($data['applicable_packages'])) {
            $data['applicable_packages'] = array_filter($data['applicable_packages']);
            if (empty($data['applicable_packages'])) {
                $data['applicable_packages'] = null; 
            }
        }

        return Coupon::create($data);
    }

    public function updateCoupon(int $id, array $data): Coupon
    {
        $coupon = Coupon::findOrFail($id);
        
        $data['code'] = strtoupper(trim($data['code']));
        $data['updated_by'] = Auth::guard('admin')->id();
        
        // Handle applicable_packages
        if (isset($data['applicable_packages']) && is_array($data['applicable_packages'])) {
            $data['applicable_packages'] = array_filter($data['applicable_packages']);
            if (empty($data['applicable_packages'])) {
                $data['applicable_packages'] = null;
            }
        }

        $coupon->update($data);
        return $coupon->fresh();
    }

    public function deleteCoupon(int $id): bool
    {
        return Coupon::findOrFail($id)->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();
        return $coupon->status;
    }


    public function validateCoupon(string $code, float $orderAmount, ?int $packageId = null, ?int $userId = null): array
    {
        $coupon = Coupon::where('code', strtoupper(trim($code)))->first();

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
                'message' => 'Minimum order amount of $' . number_format($coupon->min_order_amount, 2) . ' required.'
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
            
            // Apply max discount cap if exists
            if ($coupon->max_discount && $discount > $coupon->max_discount) {
                $discount = $coupon->max_discount;
            }
        } else {
            $discount = $coupon->value;
        }

        // Discount cannot exceed order amount
        return min($discount, $orderAmount);
    }


    public function incrementUsage(int $couponId): void
    {
        $coupon = Coupon::findOrFail($couponId);
        $coupon->increment('used_count');
    }
}