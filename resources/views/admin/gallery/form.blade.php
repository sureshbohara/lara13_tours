@extends('layouts.admin.main')

@section('title', isset($gallery) ? 'Edit Gallery' : 'Create Gallery')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Gallery" subTitle="{{ isset($gallery) ? 'Update Gallery' : 'Create Gallery' }}" :breadcrumbItems="['Dashboard', 'Gallery']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-images me-2"></i>
                {{ isset($gallery) ? 'Update Gallery' : 'Create Gallery' }}
            </h6>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="galleryForm" method="POST" enctype="multipart/form-data" action="{{ isset($gallery) ? route('admin.gallery.update', $gallery->id) : route('admin.gallery.store') }}">
                @csrf
                @if(isset($gallery))
                    @method('PUT')
                @endif

                <div class="row g-3">
                 
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Gallery Details</h5>
                                <div class="row g-3">

                                    <div class="col-12">
                                        <label class="form-label" for="name">Name / Title <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($gallery) ? $gallery->name : '') }}" placeholder="e.g., Mountain View Resort" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                        
                                    <div class="col-md-12">
                                        <label class="form-label" for="display_on">Display On</label>
                                        @php
                                            $currentDisplayOn = old('display_on', isset($gallery) ? $gallery->display_on : 'default');
                                        @endphp
                                        <select name="display_on" id="display_on" class="form-select @error('display_on') is-invalid @enderror">
                                            <option value="default" {{ $currentDisplayOn == 'default' ? 'selected' : '' }}>Default</option>
                                            <option value="memberships" {{ $currentDisplayOn == 'memberships' ? 'selected' : '' }}>Memberships</option>
                                            <option value="page" {{ $currentDisplayOn == 'page' ? 'selected' : '' }}>Page</option>
                                        </select>
                                        @error('display_on') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="alt">Alt Text (SEO)</label>
                                        <input type="text" name="alt" id="alt" class="form-control @error('alt') is-invalid @enderror" value="{{ old('alt', isset($gallery) ? $gallery->alt : '') }}" placeholder="e.g., Beautiful mountain view at sunset">
                                        @error('alt') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($gallery) ? $gallery->order_level : '0') }}" placeholder="0 = Highest priority">
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', isset($gallery) ? $gallery->status : 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', isset($gallery) ? $gallery->status : 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    

                                    <div class="col-12">
                                        <label class="form-label" for="image">Gallery Image <span class="text-danger">*</span></label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')" {{ !isset($gallery) ? 'required' : '' }}>
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($gallery) && $gallery->image_url ? $gallery->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid rounded border">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i> 
                                            <span class="btn-text">{{ isset($gallery) ? 'Update Gallery' : 'Create Gallery' }}</span>
                                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
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
        $('#galleryForm').on('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            const formData = new FormData(this);
            const submitBtn = $('#submitBtn');
            const btnText = submitBtn.find('.btn-text');
            const spinner = submitBtn.find('.spinner-border');
            const originalBtnText = btnText.html();
            
            // Show loading state
            submitBtn.prop('disabled', true);
            btnText.addClass('d-none');
            spinner.removeClass('d-none');
            
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
                        window.location.href = '{{ route("admin.gallery.index") }}'; 
                    }, 1500);
                },
                error: function(xhr) {

                    submitBtn.prop('disabled', false);
                    btnText.removeClass('d-none').html(originalBtnText);
                    spinner.addClass('d-none');
                    
               
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