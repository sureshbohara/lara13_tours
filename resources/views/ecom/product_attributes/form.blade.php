@extends('layouts.admin.main')
@section('title', isset($productAttribute) ? 'Edit Attribute' : 'Create Attribute')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Product Attributes" subTitle="{{ isset($productAttribute) ? 'Update Attribute' : 'Create Attribute' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Attributes']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-sliders me-2"></i>{{ isset($productAttribute) ? 'Update Attribute' : 'Create Attribute' }}</h6>
            <a href="{{ route('admin.product-attribute.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
        </div>
        <div class="card-body bg-light p-3">
            <form id="attrForm" method="POST" action="{{ isset($productAttribute) ? route('admin.product-attribute.update', $productAttribute->id) : route('admin.product-attribute.store') }}">
                @csrf
                @if(isset($productAttribute)) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Attribute Details</h5>

                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>Attribute Types:</strong> Dropdown (Size), Color (Swatches), Text (Engraving), Image (Patterns).
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <div class="row g-3">


                                    <div class="col-md-6">
                                        <label class="form-label">Attribute Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $productAttribute->name ?? '') }}" required placeholder="e.g., Size, Color">
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Slug</label>
                                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $productAttribute->slug ?? '') }}" placeholder="auto-generated">
                                        @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-md-12">
                                        <label class="form-label">Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                            <option value="">Select Type</option>
                                            <option value="select" {{ old('type', $productAttribute->type ?? '') == 'select' ? 'selected' : '' }}>Dropdown Select</option>
                                            <option value="color" {{ old('type', $productAttribute->type ?? '') == 'color' ? 'selected' : '' }}>Color Swatches</option>
                                            <option value="text" {{ old('type', $productAttribute->type ?? '') == 'text' ? 'selected' : '' }}>Text Input</option>
                                            <option value="image" {{ old('type', $productAttribute->type ?? '') == 'image' ? 'selected' : '' }}>Image</option>
                                        </select>
                                        @error('type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary">Attribute Values</h6>
                                        <p class="text-muted small">Add possible values (e.g., S, M, L, XL for Size)</p>
                                        <div class="valuesDisplay">
                                            @if(isset($productAttribute) && !empty($productAttribute->values))
                                                @foreach($productAttribute->values as $value)
                                                    <div class="row mb-2 valueItem">
                                                        <div class="col-10"><input type="text" name="values[]" class="form-control" value="{{ $value }}" placeholder="Value"></div>
                                                        <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeValue"><i class="bi bi-trash"></i></button></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-custom btn-sm addValue"><i class="bi bi-plus-circle"></i> Add Value</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" name="order_level" class="form-control" value="{{ old('order_level', $productAttribute->order_level ?? '0') }}" min="0">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="1" {{ old('status', $productAttribute->status ?? 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', $productAttribute->status ?? 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn"><i class="bi bi-save me-2"></i> {{ isset($productAttribute) ? 'Update Attribute' : 'Create Attribute' }}</button>
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
        $('.addValue').click(() => {
            $('.valuesDisplay').append(`<div class="row mb-2 valueItem"><div class="col-10"><input type="text" name="values[]" class="form-control" placeholder="Value"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removeValue"><i class="bi bi-trash"></i></button></div></div>`);
        });
        $(document).on('click', '.removeValue', function() { $(this).closest('.valueItem').remove(); });

        $('#attrForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.product-attribute.index") }}'; }, 1500);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false);
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $('[name="' + field + '"], [name="' + field + '[]"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
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