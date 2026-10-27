@extends('layouts.admin.main')

@section('title', isset($blog) ? 'Edit Blog' : 'Create Blog')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Blogs" subTitle="{{ isset($blog) ? 'Update Blog' : 'Create Blog' }}" :breadcrumbItems="['Dashboard', 'Blogs']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-journal-text me-2"></i>
                {{ isset($blog) ? 'Update Blog' : 'Create Blog' }}
            </h6>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="blogForm" method="POST" enctype="multipart/form-data" action="{{ isset($blog) ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}">
                @csrf
                @if(isset($blog))
                    @method('PUT')
                @endif

                <div class="row g-3">
                
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Blog Content</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="title">Blog Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', isset($blog) ? $blog->title : '') }}" placeholder="e.g., Top 10 Trekking Routes in Nepal" required>
                                        @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                               

                                    <div class="col-md-12">
                                        <label class="form-label" for="excerpt">Short Excerpt</label>
                                        <textarea name="excerpt" id="excerpt" rows="2" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Brief summary of the blog post...">{{ old('excerpt', isset($blog) ? $blog->excerpt : '') }}</textarea>
                                        @error('excerpt') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="description">Full Description</label>
                                        <textarea name="description" id="description" rows="8" class="form-control editor @error('description') is-invalid @enderror" placeholder="Write the detailed blog content here...">{{ old('description', isset($blog) ? $blog->description : '') }}</textarea>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary"><i class="bi bi-search me-2"></i>SEO Settings</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label" for="meta_title">Meta Title</label>
                                                <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', isset($blog) ? $blog->meta_title : '') }}" placeholder="SEO optimized title (max 60 chars)">
                                                @error('meta_title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="meta_description">Meta Description</label>
                                                <textarea name="meta_description" id="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Brief description for search engines (max 160 chars)...">{{ old('meta_description', isset($blog) ? $blog->meta_description : '') }}</textarea>
                                                @error('meta_description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                        <label class="form-label d-block">Categories <span class="text-danger">*</span></label>
                                        <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                            @php
                                                $selectedCategories = old('category_ids', isset($blog) ? $blog->categories->pluck('id')->toArray() : []);
                                                $parentCategories = $categories->where('parent_id', null);
                                            @endphp
                                            
                                            @forelse($parentCategories as $cat)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="category_ids[]" id="cat_{{ $cat->id }}" value="{{ $cat->id }}" 
                                                        {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-semibold" for="cat_{{ $cat->id }}">
                                                        {{ $cat->name }}
                                                    </label>
                                                </div>
                                                
                                                @foreach($cat->children as $subCat)
                                                    <div class="form-check mb-2 ms-4">
                                                        <input class="form-check-input" type="checkbox" name="category_ids[]" id="cat_{{ $subCat->id }}" value="{{ $subCat->id }}" 
                                                            {{ in_array($subCat->id, $selectedCategories) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="cat_{{ $subCat->id }}">
                                                            &nbsp;&nbsp;– {{ $subCat->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @empty
                                                <p class="text-muted small mb-0">No categories available.</p>
                                            @endforelse
                                        </div>
                                        @error('category_ids') 
                                            <div class="invalid-feedback d-block">{{ $message }}</div> 
                                        @enderror
                                    </div>

                                  
                                    <div class="col-12">
                                        <label class="form-label" for="image">Featured Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($blog) && $blog->image_url ? $blog->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid rounded border">
                                    </div>

                                
                                    <div class="col-12">
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($blog) ? $blog->order_level : '0') }}" placeholder="0 = Highest priority">
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                
                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', isset($blog) ? $blog->status : 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', isset($blog) ? $blog->status : 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                             
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', isset($blog) ? $blog->is_featured : false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Mark as Featured</label>
                                        </div>
                                    </div>

                                    
                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i> {{ isset($blog) ? 'Update Blog' : 'Create Blog' }}
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
        $('#blogForm').on('submit', function(e) {
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
                        window.location.href = '{{ route("admin.blogs.index") }}'; 
                    }, 1500);
                },
                error: function(xhr) {

                    submitBtn.prop('disabled', false);
                    
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const input = $(`[name="${field}"], [name="${field}[]"]`).first();
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