@extends('layouts.admin.main')

@section('title', isset($service) ? 'Edit Service' : 'Create Service')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Services" subTitle="{{ isset($service) ? 'Update Service' : 'Create Service' }}" :breadcrumbItems="['Dashboard', 'Services']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-briefcase me-2"></i>
                {{ isset($service) ? 'Update Service' : 'Create Service' }}
            </h6>
            <a href="{{ route('admin.service.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="serviceForm" method="POST" enctype="multipart/form-data" action="{{ isset($service) ? route('admin.service.update', $service->id) : route('admin.service.store') }}">
                @csrf
                @if(isset($service))
                    @method('PUT')
                @endif

                <div class="row g-3">
                
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Content Details</h5>
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title ?? '') }}" placeholder="e.g., Homestay Booking" required>
                                        @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="icon">Icon Class</label>
                                        <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $service->icon ?? '') }}" placeholder="e.g., bi-house-heart">
                                        @error('icon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="subtitle">Subtitle</label>
                                        <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $service->subtitle ?? '') }}" placeholder="e.g., Experience Authentic Nepali Living">
                                        @error('subtitle') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label" for="short_content">Short Content</label>
                                        <textarea name="short_content" id="short_content" rows="2" class="form-control @error('short_content') is-invalid @enderror" placeholder="Brief summary of the service (1-2 sentences)...">{{ old('short_content', $service->short_content ?? '') }}</textarea>
                                        @error('short_content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="long_content">Long Content</label>
                                        <textarea name="long_content" id="long_content" rows="6" class="form-control editor @error('long_content') is-invalid @enderror" placeholder="Detailed description of the service...">{{ old('long_content', $service->long_content ?? '') }}</textarea>
                                        @error('long_content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                            

                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary"><i class="bi bi-gear me-2"></i>Process Items</h6>
                                        <div id="processItemDisplay">
                                            @if(isset($service) && is_array($service->process_item))
                                                @foreach($service->process_item as $index => $item)
                                                    <div class="row processItemRow g-2 mb-3 p-3 border rounded bg-light align-items-end">
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted">Icon Class</label>
                                                            <input type="text" name="process_item[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ e($item['icon'] ?? '') }}" placeholder="e.g., bi-check-circle">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small text-muted">Title</label>
                                                            <input type="text" name="process_item[{{ $index }}][title]" class="form-control form-control-sm" value="{{ e($item['title'] ?? '') }}" placeholder="e.g., Step 1">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label small text-muted">Content</label>
                                                            <textarea name="process_item[{{ $index }}][content]" class="form-control form-control-sm" rows="2" placeholder="Brief description of this step...">{{ e($item['content'] ?? '') }}</textarea>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="button" class="btn btn-outline-danger btn-sm removeProcessItem"><i class="bi bi-trash"></i> Remove</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm addProcessItem"><i class="bi bi-plus-circle"></i> Add Process Item</button>
                                    </div>

                              
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary"><i class="bi bi-star me-2"></i>Service Highlights</h6>
                                        <div id="highlightDisplay">
                                            @if(isset($service) && is_array($service->highlight))
                                                @foreach($service->highlight as $index => $highlight)
                                                    <div class="row highlightRow g-2 mb-2 align-items-center">
                                                        <div class="col-10">
                                                            <input type="text" name="highlight[{{ $index }}]" class="form-control" value="{{ e($highlight) }}" placeholder="e.g., 24/7 Customer Support">
                                                        </div>
                                                        <div class="col-2">
                                                            <button type="button" class="btn btn-outline-danger btn-sm w-100 removeHighlight" title="Remove"><i class="bi bi-trash"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm addHighlight"><i class="bi bi-plus-circle"></i> Add Highlight</button>
                                    </div>


                                    <h5 class="card-title mb-3 border-bottom pb-2">SEO</h5>


                                    
                                    <div class="col-12">
                                        <label class="form-label" for="meta_keywords">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords', $service->meta_keywords ?? '') }}" placeholder="e.g., homestay, nepal, booking">
                                        @error('meta_keywords') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Brief description for search engines (max 160 chars)...">{{ old('meta_description', $service->meta_description ?? '') }}</textarea>
                                        @error('meta_description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', $service->order_level ?? '0') }}" placeholder="0 = Highest priority">
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', $service->status ?? 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', $service->status ?? 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 mt-2 pt-2 border-top">
                                        <label class="form-label" for="image">Main Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($service) && $service->image_url ? $service->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid rounded border" >
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="feature_image">Feature Image</label>
                                        <input type="file" name="feature_image" id="feature_image" class="form-control @error('feature_image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'featureImagePreview')">
                                        @error('feature_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($service) && $service->feature_image_url ? $service->feature_image_url : asset('default/noimage.png') }}" id="featureImagePreview" class="img-fluid rounded border" >
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i> 
                                            <span class="btn-text">{{ isset($service) ? 'Update Service' : 'Create Service' }}</span>
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
     
        $('.addProcessItem').on('click', function() {
            const index = Date.now();
            const html = `
                <div class="row processItemRow g-2 mb-3 p-3 border rounded bg-light align-items-end">
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Icon Class</label>
                        <input type="text" name="process_item[${index}][icon]" class="form-control form-control-sm" placeholder="e.g., bi-check-circle">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Title</label>
                        <input type="text" name="process_item[${index}][title]" class="form-control form-control-sm" placeholder="e.g., Step 1">
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-muted">Content</label>
                        <textarea name="process_item[${index}][content]" class="form-control form-control-sm" rows="2" placeholder="Brief description of this step..."></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm removeProcessItem"><i class="bi bi-trash"></i> Remove</button>
                    </div>
                </div>
            `;
            $('#processItemDisplay').append(html);
        });

       
        $(document).on('click', '.removeProcessItem', function() {
            $(this).closest('.processItemRow').remove();
        });


        $('.addHighlight').on('click', function() {
            const index = Date.now();
            const html = `
                <div class="row highlightRow g-2 mb-2 align-items-center">
                    <div class="col-10">
                        <input type="text" name="highlight[${index}]" class="form-control" placeholder="e.g., 24/7 Customer Support">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 removeHighlight" title="Remove"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            `;
            $('#highlightDisplay').append(html);
        });

   
        $(document).on('click', '.removeHighlight', function() {
            $(this).closest('.highlightRow').remove();
        });

        
        $('#serviceForm').on('submit', function(e) {
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
                        window.location.href = '{{ route("admin.service.index") }}'; 
                    }, 1500);
                },
                error: function(xhr) {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    btnText.removeClass('d-none').html(originalBtnText);
                    spinner.addClass('d-none');
                    
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const baseField = field.split('[')[0];
                            const input = $(`[name^="${baseField}"]`).first();
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