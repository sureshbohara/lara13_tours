@extends('layouts.admin.main')
@section('title', isset($offer) ? 'Edit Offer' : 'Create Offer')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Offers" subTitle="{{ isset($offer) ? 'Update Offer' : 'Create Offer' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Offers']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-percent me-2"></i>{{ isset($offer) ? 'Update Offer' : 'Create Offer' }}</h6>
            <a href="{{ route('admin.offer.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
        </div>
        <div class="card-body bg-light p-3">
            <form id="offerForm" method="POST" action="{{ isset($offer) ? route('admin.offer.update', $offer->id) : route('admin.offer.store') }}">
                @csrf
                @if(isset($offer)) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Offer Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Offer Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $offer->name ?? '') }}" required placeholder="e.g., Buy 2 Get 1 Free Summer Sale">
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2">{{ old('description', $offer->description ?? '') }}</textarea>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Offer Type <span class="text-danger">*</span></label>
                                        <select name="offer_type" id="offerType" class="form-select @error('offer_type') is-invalid @enderror" required>
                                            <option value="">Select Type</option>
                                            <option value="buy_x_get_y_free" {{ old('offer_type', $offer->offer_type ?? '') == 'buy_x_get_y_free' ? 'selected' : '' }}>Buy X Get Y Free</option>
                                            <option value="buy_x_get_discount" {{ old('offer_type', $offer->offer_type ?? '') == 'buy_x_get_discount' ? 'selected' : '' }}>Buy X Get Discount</option>
                                            <option value="percentage_discount" {{ old('offer_type', $offer->offer_type ?? '') == 'percentage_discount' ? 'selected' : '' }}>Percentage Discount</option>
                                            <option value="flat_discount" {{ old('offer_type', $offer->offer_type ?? '') == 'flat_discount' ? 'selected' : '' }}>Flat Discount</option>
                                            <option value="free_shipping" {{ old('offer_type', $offer->offer_type ?? '') == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                        </select>
                                        @error('offer_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Apply On <span class="text-danger">*</span></label>
                                        <select name="apply_on" id="applyOn" class="form-select @error('apply_on') is-invalid @enderror" required>
                                            <option value="all_products" {{ old('apply_on', $offer->apply_on ?? 'all_products') == 'all_products' ? 'selected' : '' }}>All Products</option>
                                            <option value="specific_products" {{ old('apply_on', $offer->apply_on ?? '') == 'specific_products' ? 'selected' : '' }}>Specific Products</option>
                                            <option value="specific_categories" {{ old('apply_on', $offer->apply_on ?? '') == 'specific_categories' ? 'selected' : '' }}>Specific Categories</option>
                                        </select>
                                        @error('apply_on') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 buyXSection" style="display:none;">
                                        <div class="row g-3 p-3 bg-light rounded">
                                            <div class="col-md-6">
                                                <label class="form-label">Buy Quantity (X)</label>
                                                <input type="number" name="buy_quantity" class="form-control" value="{{ old('buy_quantity', $offer->buy_quantity ?? '1') }}" min="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Get Quantity (Y) Free</label>
                                                <input type="number" name="get_quantity" class="form-control" value="{{ old('get_quantity', $offer->get_quantity ?? '0') }}" min="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 discountSection" style="display:none;">
                                        <div class="col-md-6">
                                            <label class="form-label">Discount Value</label>
                                            <input type="number" step="0.01" name="discount_value" class="form-control" value="{{ old('discount_value', $offer->discount_value ?? '') }}">
                                        </div>
                                    </div>

                                    <div id="productSelection" style="display:none;" class="col-12 mt-3">
                                        <h6 class="mb-3">Select Products</h6>
                                        <div class="scrollable-container p-3 border rounded" style="max-height: 250px; overflow-y: auto;">
                                            @foreach($products ?? [] as $product)
                                                <div class="form-check mb-1">
                                                    <input type="checkbox" class="form-check-input" name="product_ids[]" id="prod-{{ $product->id }}" value="{{ $product->id }}" {{ in_array($product->id, old('product_ids', $offer->product_ids ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="prod-{{ $product->id }}">{{ $product->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div id="categorySelection" style="display:none;" class="col-12 mt-3">
                                        <h6 class="mb-3">Select Categories</h6>
                                        <div class="scrollable-container p-3 border rounded" style="max-height: 250px; overflow-y: auto;">
                                            @foreach($categories ?? [] as $category)
                                                <div class="form-check mb-1">
                                                    <input type="checkbox" class="form-check-input" name="category_ids[]" id="cat-{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', $offer->category_ids ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold" for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Validity & Limits</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', isset($offer) && $offer->start_date ? $offer->start_date->format('Y-m-d') : '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', isset($offer) && $offer->end_date ? $offer->end_date->format('Y-m-d') : '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Min Order Amount</label>
                                        <input type="number" step="0.01" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $offer->min_order_amount ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Max Total Uses</label>
                                        <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses', $offer->max_uses ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Max Uses/User</label>
                                        <input type="number" name="max_uses_per_user" class="form-control" value="{{ old('max_uses_per_user', $offer->max_uses_per_user ?? '1') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Priority</label>
                                        <input type="number" name="priority" class="form-control" value="{{ old('priority', $offer->priority ?? '0') }}" min="0">
                                        <small class="text-muted">Higher priority applies first</small>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $offer->status ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status"><strong>Active</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn"><i class="bi bi-save me-2"></i> {{ isset($offer) ? 'Update Offer' : 'Create Offer' }}</button>
                                    </div>
                                </div>
                            </div>
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
        function toggleSections() {
            const type = $('#offerType').val();
            const applyOn = $('#applyOn').val();
            $('.buyXSection').toggle(['buy_x_get_y_free', 'buy_x_get_discount'].includes(type));
            $('.discountSection').toggle(['buy_x_get_discount', 'percentage_discount', 'flat_discount'].includes(type));
            $('#productSelection').toggle(applyOn === 'specific_products');
            $('#categorySelection').toggle(applyOn === 'specific_categories');
        }
        $('#offerType, #applyOn').on('change', toggleSections);
        toggleSections();

        $('#offerForm').on('submit', function(e) {
            e.preventDefault();
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
            const formData = new FormData(this);
            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true);
            $.ajax({
                type: 'POST', url: $(this).attr('action'), data: formData, contentType: false, processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => { window.location.href = '{{ route("admin.offer.index") }}'; }, 1500);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false);
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $('[name="' + field + '"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the form errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                }
            });
        });
    });
</script>
@endpush