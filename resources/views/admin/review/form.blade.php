@extends('layouts.admin.main')

@section('title', isset($review) ? 'Edit Review' : 'Create Review')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Reviews" subTitle="{{ isset($review) ? 'Update Review' : 'Create Review' }}" :breadcrumbItems="['Dashboard', 'Reviews']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-star me-2"></i>
                {{ isset($review) ? 'Update Review' : 'Create Review' }}
            </h6>
            <a href="{{ route('admin.review.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="reviewForm" method="POST" enctype="multipart/form-data" action="{{ isset($review) ? route('admin.review.update', $review->id) : route('admin.review.store') }}">
                @csrf
                @if(isset($review))
                    @method('PUT')
                @endif

                <div class="row g-3">
                
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Review Details</h5>
                                
                                <div class="row g-3">

                                    <div class="col-md-12">
                                        <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $review->name ?? '') }}" placeholder="Reviewer's full name" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $review->email ?? '') }}" placeholder="reviewer@example.com">
                                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="address">Address / Location</label>
                                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $review->address ?? '') }}" placeholder="e.g., Kathmandu, Nepal">
                                        @error('address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="rating">Rating (1-5) <span class="text-danger">*</span></label>
                                        <input type="number" name="rating" id="rating" min="1" max="5" class="form-control @error('rating') is-invalid @enderror" value="{{ old('rating', $review->rating ?? 5) }}" placeholder="1 to 5" required>
                                        @error('rating') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="review">Review Text <span class="text-danger">*</span></label>
                                        <textarea name="review" id="review" rows="3" class="form-control @error('review') is-invalid @enderror" placeholder="What did the customer say..." required>{{ old('review', $review->review ?? '') }}</textarea>
                                        @error('review') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="content">Additional Content</label>
                                        <textarea name="content" id="content" rows="3" class="form-control @error('content') is-invalid @enderror" placeholder="Any extra details or notes...">{{ old('content', $review->content ?? '') }}</textarea>
                                        @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings & Image</h5>
                                
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="display_on">Display On</label>
                                        <input type="text" name="display_on" id="display_on" class="form-control @error('display_on') is-invalid @enderror" value="{{ old('display_on', $review->display_on ?? 'homepage') }}" placeholder="e.g., homepage, about">
                                        @error('display_on') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', $review->order_level ?? '0') }}" placeholder="0 = Highest priority">
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', $review->status ?? 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', $review->status ?? 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="image">Reviewer Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($review) && $review->image_url ? $review->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid rounded border">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i> 
                                            <span class="btn-text">{{ isset($review) ? 'Update Review' : 'Create Review' }}</span>
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
        $('#reviewForm').on('submit', function(e) {
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
                        window.location.href = '{{ route("admin.review.index") }}'; 
                    }, 1500);
                },
                error: function(xhr) {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    btnText.removeClass('d-none').html(originalBtnText);
                    spinner.addClass('d-none');
                    
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