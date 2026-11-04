@extends('layouts.admin.main')
@section('title', isset($brand) ? 'Edit Brand' : 'Create Brand')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Brands" subTitle="{{ isset($brand) ? 'Update Brand' : 'Create Brand' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Brands']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">{{ isset($brand) ? 'Update Brand' : 'Create Brand' }}</h6>
            <a href="{{ route('admin.brand.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
        </div>
        <div class="card-body bg-light p-3">
            <form id="brandForm" method="POST" enctype="multipart/form-data" action="{{ isset($brand) ? route('admin.brand.update', $brand->id) : route('admin.brand.store') }}">
                @csrf
                @if(isset($brand)) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2"> Brand Details </h5>
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name ?? '') }}" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Website URL</label>
                                        <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $brand->website ?? '') }}" placeholder="https://example.com">
                                        @error('website') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $brand->description ?? '') }}</textarea>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary"><i class="bi bi-search me-2"></i>SEO Settings</h6>
                                        <div class="row g-3">

                                            <div class="col-12">
                                                <label class="form-label">Meta Title</label>
                                                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $brand->meta_title ?? '') }}">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Meta Description</label>
                                                <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $brand->meta_description ?? '') }}</textarea>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings & Media</h5>
                                <div class="row g-3">


                                    <div class="col-12">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" name="order_level" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', $brand->order_level ?? '0') }}" min="0">
                                        <small class="text-muted">Lower numbers display first</small>
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', $brand->status ?? 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', $brand->status ?? 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label">Brand Logo</label>
                                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'logoPreview')">
                                        @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($brand) && $brand->logo_url ? $brand->logo_url : asset('default/noimage.png') }}" id="logoPreview" class="img-fluid rounded border" style="max-height: 120px; object-fit: contain;">
                                    </div>


                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn"><i class="bi bi-save me-2"></i> {{ isset($brand) ? 'Update Brand' : 'Create Brand' }}</button>
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
        $('#brandForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.brand.index") }}'; }, 1500);
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