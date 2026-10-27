@extends('layouts.admin.main')

@section('title', isset($banner) ? 'Edit Banner' : 'Create Banner')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Banners" subTitle="{{ isset($banner) ? 'Update Banner' : 'Create Banner' }}" :breadcrumbItems="['Dashboard', 'Banners']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-image me-2"></i>
                {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
            </h6>
            <a href="{{ route('admin.banner.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="bannerForm" method="POST" enctype="multipart/form-data" action="{{ isset($banner) ? route('admin.banner.update', $banner->id) : route('admin.banner.store') }}">
                @csrf
                @if(isset($banner))
                    @method('PUT')
                @endif

                <div class="row g-3">
                  
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Banner Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', isset($banner) ? $banner->title : '') }}" placeholder="e.g., Welcome to Ez Property" required>
                                        @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="subtitle">Subtitle</label>
                                        <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', isset($banner) ? $banner->subtitle : '') }}" placeholder="e.g., Find your perfect stay in Nepal">
                                        @error('subtitle') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Brief description of the banner...">{{ old('description', isset($banner) ? $banner->description : '') }}</textarea>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($banner) ? $banner->order_level : '0') }}" placeholder="0 = Highest priority">
                                        <small class="text-muted">Lower numbers display first</small>
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', isset($banner) ? $banner->status : 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', isset($banner) ? $banner->status : 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label" for="image">Banner Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-6 text-center mb-2">
                                        <img src="{{ isset($banner) && $banner->image_url ? $banner->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid rounded border">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i>
                                            {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
                                        </button>
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
        $('#bannerForm').on('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            const formData = new FormData(this);
            const submitBtn = $('#submitBtn');
            
            // Prevent double submission
            submitBtn.prop('disabled', true);
            
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => { 
                        window.location.href = '{{ route("admin.banner.index") }}'; 
                    }, 1500);
                },
                error: function(xhr) {
                    // Re-enable button on error
                    submitBtn.prop('disabled', false);
                    
                    // Handle validation errors
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const input = $('[name="' + field + '"]');
                            input.addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
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