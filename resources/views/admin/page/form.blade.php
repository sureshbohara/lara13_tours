@extends('layouts.admin.main')

@section('title', isset($page) ? 'Edit Page' : 'Create Page')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Pages" subTitle="{{ isset($page) ? 'Update Page' : 'Create Page' }}" :breadcrumbItems="['Dashboard', 'Pages']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-file-earmark-text me-2"></i>
                {{ isset($page) ? 'Update Page' : 'Create Page' }}
            </h6>
            <a href="{{ route('admin.page.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="pageForm" method="POST" enctype="multipart/form-data" action="{{ isset($page) ? route('admin.page.update', $page->id) : route('admin.page.store') }}">
                @csrf
                @if(isset($page))
                    @method('PUT')
                @endif

                <div class="row g-3">
          
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Content</h5>
                                
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title ?? '') }}" placeholder="Enter page title" required>
                                        @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                  


                                    <div class="col-12">
                                        <label class="form-label" for="short_content">Short Content / Excerpt</label>
                                        <textarea name="short_content" id="short_content" rows="2" class="form-control @error('short_content') is-invalid @enderror" placeholder="Brief summary of the page...">{{ old('short_content', $page->short_content ?? '') }}</textarea>
                                        @error('short_content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="content">Main Content</label>
                                        <textarea name="content" id="content" rows="8" class="form-control editor @error('content') is-invalid @enderror">{{ old('content', $page->content ?? '') }}</textarea>
                                        @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <hr class="my-3">
                                        <h6 class="text-muted mb-3"><i class="bi bi-search me-1"></i> SEO Settings</h6>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="meta_title">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', $page->meta_title ?? '') }}" placeholder="SEO optimized title">
                                        @error('meta_title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="meta_keywords">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}" placeholder="keyword1, keyword2, keyword3">
                                        @error('meta_keywords') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Brief description for search engines...">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                                        @error('meta_description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Image & Settings</h5>
                                
                                <div class="row g-3">


                                    <div class="col-md-12">
                                        <label class="form-label" for="icon">Icon Class</label>
                                        <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $page->icon ?? '') }}" placeholder="e.g., bi-info-circle">
                                        @error('icon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    
                                    <div class="col-12">
                                        <label class="form-label" for="image">Page Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($page) && $page->image_url ? $page->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid rounded border" >
                                    </div>

                                     <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="show_in_menu" value="0">
                                            <input class="form-check-input" type="checkbox" name="show_in_menu" value="1" id="show_in_menu" {{ old('show_in_menu', $page->show_in_menu ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_in_menu">Show in Main Menu</label>
                                        </div>
                                    </div>

                                 
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="show_in_footer" value="0">
                                            <input class="form-check-input" type="checkbox" name="show_in_footer" value="1" id="show_in_footer" {{ old('show_in_footer', $page->show_in_footer ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_in_footer">Show in Footer</label>
                                        </div>
                                    </div>

                                
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_featured" value="0">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $page->is_featured ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Mark as Featured</label>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', $page->order_level ?? '0') }}" placeholder="0 = Highest priority">
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', $page->status ?? 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', $page->status ?? 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i> 
                                            <span class="btn-text">{{ isset($page) ? 'Update Page' : 'Create Page' }}</span>
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
        $('#pageForm').on('submit', function(e) {
            e.preventDefault();
            

            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            const formData = new FormData(this);
            const submitBtn = $('#submitBtn');
            const btnText = submitBtn.find('.btn-text');
            const spinner = submitBtn.find('.spinner-border');
            const originalBtnText = btnText.html();
            
      
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
                        window.location.href = '{{ route("admin.page.index") }}'; 
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