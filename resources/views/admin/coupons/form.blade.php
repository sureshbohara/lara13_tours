@extends('layouts.admin.main')

@section('title', isset($coupon) ? 'Edit Coupon' : 'Create Coupon')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Marketing" subTitle="{{ isset($coupon) ? 'Edit Coupon' : 'Create Coupon' }}" 
                  :breadcrumbItems="['Dashboard', 'Coupons']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-ticket-perforated me-2"></i>
                {{ isset($coupon) ? 'Edit Coupon' : 'Create New Coupon' }}
            </h6>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="couponForm" method="POST" 
                  action="{{ isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}">
                @csrf
                @if(isset($coupon)) @method('PUT') @endif

                <div class="row g-4">
                    {{-- Left Column: Basic Info --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Coupon Details</h5>
                                
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                               value="{{ old('code', $coupon->code ?? '') }}" 
                                               placeholder="e.g., NEPAL2024" required 
                                               style="text-transform: uppercase;">
                                        <small class="text-muted">Uppercase letters, numbers, hyphens, underscores only</small>
                                        @error('code') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Type <span class="text-danger">*</span></label>
                                        <select name="type" id="couponType" class="form-select @error('type') is-invalid @enderror" required>
                                            <option value="percentage" {{ old('type', $coupon->type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                            <option value="fixed" {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                        </select>
                                        @error('type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-md-3">
                                        <label class="form-label">Value <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" name="value" id="couponValue" step="0.01" min="0.01"
                                                   class="form-control @error('value') is-invalid @enderror" 
                                                   value="{{ old('value', $coupon->value ?? '') }}" required>
                                            <span class="input-group-text" id="valueUnit">%</span>
                                        </div>
                                        @error('value') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label">Description (Internal Notes)</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                                  rows="2" placeholder="e.g., Summer sale campaign 2024">{{ old('description', $coupon->description ?? '') }}</textarea>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mt-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Conditions</h5>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Minimum Order Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="min_order_amount" step="0.01" min="0"
                                                   class="form-control @error('min_order_amount') is-invalid @enderror" 
                                                   value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}" 
                                                   placeholder="0.00 (no minimum)">
                                        </div>
                                        <small class="text-muted">Customer must spend at least this amount</small>
                                        @error('min_order_amount') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6" id="maxDiscountField">
                                        <label class="form-label">Maximum Discount Cap</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="max_discount" step="0.01" min="0"
                                                   class="form-control @error('max_discount') is-invalid @enderror" 
                                                   value="{{ old('max_discount', $coupon->max_discount ?? '') }}" 
                                                   placeholder="Optional">
                                        </div>
                                        <small class="text-muted">Only for percentage type</small>
                                        @error('max_discount') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Total Usage Limit</label>
                                        <input type="number" name="usage_limit" min="1"
                                               class="form-control @error('usage_limit') is-invalid @enderror" 
                                               value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" 
                                               placeholder="Leave empty for unlimited">
                                        <small class="text-muted">How many times this coupon can be used in total</small>
                                        @error('usage_limit') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Per User Limit</label>
                                        <input type="number" name="per_user_limit" min="1"
                                               class="form-control @error('per_user_limit') is-invalid @enderror" 
                                               value="{{ old('per_user_limit', $coupon->per_user_limit ?? '1') }}" 
                                               placeholder="1">
                                        <small class="text-muted">How many times each user can use this coupon</small>
                                        @error('per_user_limit') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="start_date" 
                                               class="form-control @error('start_date') is-invalid @enderror" 
                                               value="{{ old('start_date', isset($coupon) ? $coupon->start_date->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" 
                                               required>
                                        @error('start_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">End Date</label>
                                        <input type="datetime-local" name="end_date" 
                                               class="form-control @error('end_date') is-invalid @enderror" 
                                               value="{{ old('end_date', isset($coupon) && $coupon->end_date ? $coupon->end_date->format('Y-m-d\TH:i') : '') }}">
                                        <small class="text-muted">Leave empty for no expiry</small>
                                        @error('end_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', $coupon->status ?? 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', $coupon->status ?? 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mt-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Applicable Packages</h5>
                                <div class="scrollable-container mb-3 p-2" style="max-height: 250px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem;">
                                    @php
                                        $selectedPackages = old('applicable_packages', isset($coupon) && $coupon->applicable_packages ? $coupon->applicable_packages : []);
                                    @endphp
                                    
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="selectAllPackages">
                                        <label class="form-check-label fw-bold" for="selectAllPackages">
                                            Select All (Apply to all packages)
                                        </label>
                                    </div>
                                    <hr>
                                    
                                    @foreach($packages as $package)
                                        <div class="form-check mb-1">
                                            <input type="checkbox" class="form-check-input package-checkbox" 
                                                   name="applicable_packages[]" 
                                                   id="pkg-{{ $package->id }}" 
                                                   value="{{ $package->id }}"
                                                   {{ in_array($package->id, $selectedPackages) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pkg-{{ $package->id }}">
                                                {{ $package->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">Leave empty to apply to all packages</small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                <i class="bi bi-save me-2"></i>
                                {{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function updateValueUnit() {
            const type = $('#couponType').val();
            $('#valueUnit').text(type === 'percentage' ? '%' : '$');
            
            if (type === 'percentage') {
                $('#maxDiscountField').show();
            } else {
                $('#maxDiscountField').hide();
            }
        }
        
        $('#couponType').on('change', updateValueUnit);
        updateValueUnit();

   
        $('#selectAllPackages').on('change', function() {
            $('.package-checkbox').prop('checked', this.checked);
        });


        $('input[name="code"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });

 
        $('#couponForm').on('submit', function(e) {
            e.preventDefault();
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            const formData = $(this).serialize();
            const submitBtn = $('#submitBtn');
            const originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    setTimeout(() => window.location.href = '{{ route("admin.coupons.index") }}', 1500);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const input = $('[name="' + field + '"]');
                            input.addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the form errors');
                    } else {
                        toastr.error('Something went wrong');
                    }
                }
            });
        });
    });
</script>
@endpush