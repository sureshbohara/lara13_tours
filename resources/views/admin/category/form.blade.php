@extends('layouts.admin.main')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Categories" subTitle="{{ isset($category) ? 'Update Category' : 'Create Category' }}" :breadcrumbItems="['Dashboard', 'Categories']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-folder me-2"></i>
                {{ isset($category) ? 'Update Category' : 'Create Category' }}
            </h6>
            <a href="{{ route('admin.category.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="categoryForm" method="POST" enctype="multipart/form-data" action="{{ isset($category) ? route('admin.category.update', $category->id) : route('admin.category.store') }}">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    {{-- Left Column: Category Details --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Category Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($category) ? $category->name : '') }}" placeholder="e.g., Adventure Tours" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="parent_id">Parent Category</label>
                                        <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                            <option value="">-- None (Root Category) --</option>
                                            @foreach($parentCategories as $parent)
                                                <option value="{{ $parent->id }}" {{ old('parent_id', isset($category) ? $category->parent_id : '') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', isset($category) ? $category->slug : '') }}" placeholder="e.g., adventure-tours">
                                        @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="font_icon">Font Icon Class</label>
                                        <input type="text" name="font_icon" id="font_icon" class="form-control @error('font_icon') is-invalid @enderror" value="{{ old('font_icon', isset($category) ? $category->font_icon : '') }}" placeholder="e.g., bi bi-map">
                                        @error('font_icon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="excerpt">Short Excerpt</label>
                                        <textarea name="excerpt" id="excerpt" rows="2" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Brief summary of the category...">{{ old('excerpt', isset($category) ? $category->excerpt : '') }}</textarea>
                                        @error('excerpt') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="description">Full Description</label>
                                        <textarea name="description" id="description" rows="4" class="form-control editor @error('description') is-invalid @enderror" placeholder="Detailed description of the category...">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary"><i class="bi bi-search me-2"></i>SEO Settings</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label" for="meta_keywords">Meta Keywords</label>
                                                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords', isset($category) ? $category->meta_keywords : '') }}" placeholder="e.g., adventure, trekking, nepal tours">
                                                <small class="text-muted">Separate keywords with commas (max 255 characters)</small>
                                                @error('meta_keywords') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label" for="meta_description">Meta Description</label>
                                                <textarea name="meta_description" id="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Brief description for search engines (recommended: 150-160 characters)...">{{ old('meta_description', isset($category) ? $category->meta_description : '') }}</textarea>
                                                <small class="text-muted">This will appear in search engine results</small>
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
                                        <label class="form-label" for="display_on">Display On</label>
                                        @php $currentDisplay = old('display_on', isset($category) ? $category->display_on : 'default'); @endphp
                                        <select name="display_on" id="display_on" class="form-select @error('display_on') is-invalid @enderror">
                                            <option value="header" {{ $currentDisplay == 'header' ? 'selected' : '' }}>Header</option>
                                            <option value="default" {{ $currentDisplay == 'default' ? 'selected' : '' }}>Default</option>
                                            <option value="home" {{ $currentDisplay == 'home' ? 'selected' : '' }}>Home</option>
                                            <option value="page" {{ $currentDisplay == 'page' ? 'selected' : '' }}>Page</option>
                                        </select>
                                        @error('display_on') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($category) ? $category->order_level : '0') }}" placeholder="0 = Highest priority">
                                        <small class="text-muted">Lower numbers display first</small>
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', isset($category) ? $category->status : 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', isset($category) ? $category->status : 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="image">Category Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($category) && $category->image_url ? $category->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid border">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i>
                                            {{ isset($category) ? 'Update Category' : 'Create Category' }}
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
        $('#categoryForm').on('submit', function(e) {
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
                        window.location.href = '{{ route("admin.category.index") }}'; 
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