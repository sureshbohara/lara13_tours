@extends('layouts.admin.main')
@section('title', isset($product) ? 'Edit Product' : 'Create Product')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Products" subTitle="{{ isset($product) ? 'Update Product' : 'Create Product' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Products']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-box-seam me-2"></i>{{ isset($product) ? 'Update Product' : 'Create Product' }}</h6>
            <a href="{{ route('admin.product.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
        </div>
        <div class="card-body bg-light p-3">
            <form id="productForm" method="POST" enctype="multipart/form-data" action="{{ isset($product) ? route('admin.product.update', $product->id) : route('admin.product.store') }}">
                @csrf
                @if(isset($product)) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Basic Information</h5>
                                <div class="row g-3">


                                    <div class="col-md-6">
                                        <label class="form-label">Product Type <span class="text-danger">*</span></label>
                                        <select name="product_type" id="productType" class="form-select @error('product_type') is-invalid @enderror" required>
                                            <option value="simple" {{ old('product_type', $product->product_type ?? 'simple') == 'simple' ? 'selected' : '' }}>Simple Product</option>
                                            <option value="variable" {{ old('product_type', $product->product_type ?? '') == 'variable' ? 'selected' : '' }}>Variable Product</option>
                                            <option value="grouped" {{ old('product_type', $product->product_type ?? '') == 'grouped' ? 'selected' : '' }}>Grouped Product</option>
                                            <option value="digital" {{ old('product_type', $product->product_type ?? '') == 'digital' ? 'selected' : '' }}>Digital / Downloadable</option>
                                        </select>
                                        @error('product_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name ?? '') }}" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label">Full Description</label>
                                        <textarea name="description" class="form-control editor @error('description') is-invalid @enderror" rows="6">{{ old('description', $product->description ?? '') }}</textarea>
                                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <h5 class="card-title mb-3 mt-4 pt-3 border-top border-bottom pb-2">Pricing & Inventory</h5>


                                    <div class="col-md-6">
                                        <label class="form-label">Regular Price <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="regular_price" class="form-control @error('regular_price') is-invalid @enderror" value="{{ old('regular_price', $product->regular_price ?? '') }}" required>
                                        @error('regular_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">Sale Price</label>
                                        <input type="number" step="0.01" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $product->sale_price ?? '') }}">
                                        @error('sale_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12 mt-3 pt-3 border-top">
                                        <div class="row g-3">


                                            <div class="col-md-3">
                                                <div class="form-check form-switch mt-4">
                                                     <input type="hidden" name="manage_stock" value="0">
                                                     <input class="form-check-input" type="checkbox" name="manage_stock" value="1" id="manageStock" {{ old('manage_stock', $product->manage_stock ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="manageStock">Manage Stock</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">Stock Qty</label>
                                                <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity ?? '0') }}" min="0">
                                            </div>


                                            <div class="col-md-3">
                                                <label class="form-label">Low Stock Alert</label>
                                                <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? '5') }}" min="0">
                                            </div>


                                            <div class="col-md-3">
                                                <label class="form-label">Stock Status</label>
                                                <select name="stock_status" class="form-select">
                                                    <option value="in_stock" {{ old('stock_status', $product->stock_status ?? 'in_stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                                    <option value="out_of_stock" {{ old('stock_status', $product->stock_status ?? '') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                                    <option value="on_backorder" {{ old('stock_status', $product->stock_status ?? '') == 'on_backorder' ? 'selected' : '' }}>On Backorder</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div id="groupedSection" style="{{ old('product_type', $product->product_type ?? '') === 'grouped' ? '' : 'display:none;' }}" class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3">Grouped Products</h6>
                                        <div class="bundleDisplay">
                                            @if(isset($product) && $product->bundles)
                                                @foreach($product->bundles as $index => $bundle)
                                                    <div class="row mb-2 bundleItem">
                                                        <div class="col-6">
                                                            <select name="bundle_products[{{ $index }}][child_product_id]" class="form-select">
                                                                <option value="">Select Product</option>
                                                                @foreach($allProducts ?? [] as $p)
                                                                    <option value="{{ $p->id }}" {{ $bundle->child_product_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-4"><input type="number" name="bundle_products[{{ $index }}][quantity]" class="form-control" value="{{ $bundle->quantity }}" min="1"></div>
                                                        <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeBundle"><i class="bi bi-trash"></i></button></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-custom btn-sm addBundle"><i class="bi bi-plus-circle"></i> Add Product</button>
                                    </div>

                                    <div id="digitalSection" style="{{ old('product_type', $product->product_type ?? '') === 'digital' ? '' : 'display:none;' }}" class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3">Digital Product Settings</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Downloadable File</label>
                                                <input type="file" name="downloadable_file" class="form-control">
                                                @if(isset($product) && $product->downloadable_file)
                                                    <small class="text-muted d-block">Current: {{ $product->downloadable_file }}</small>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Download Limit</label>
                                                <input type="number" name="download_limit" class="form-control" value="{{ old('download_limit', $product->download_limit ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Expiry (Days)</label>
                                                <input type="number" name="download_expiry_days" class="form-control" value="{{ old('download_expiry_days', $product->download_expiry_days ?? '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="card-title mb-3 mt-4 pt-3 border-top border-bottom pb-2"><i class="bi bi-question-circle me-2"></i>FAQs</h5>
                                    <div class="faqsDisplay">
                                        @if(isset($product) && !empty($product->faqs))
                                            @foreach($product->faqs as $index => $faq)
                                                <div class="card mb-2 faqItem">
                                                    <div class="card-body p-2">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <input type="text" name="faqs[{{ $index }}][question]" class="form-control mb-2" placeholder="Question" value="{{ $faq['question'] ?? '' }}">
                                                                <textarea name="faqs[{{ $index }}][answer]" class="form-control" rows="2" placeholder="Answer">{{ $faq['answer'] ?? '' }}</textarea>
                                                            </div>
                                                            <div class="col-1 d-flex align-items-start">
                                                                <button type="button" class="btn btn-danger btn-sm removeFaq"><i class="bi bi-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-custom btn-sm addFaq"><i class="bi bi-plus-circle"></i> Add FAQ</button>

                                    <h5 class="card-title mb-3 mt-4 pt-3 border-top border-bottom pb-2">SEO Settings</h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title ?? '') }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
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
                                        <label class="form-label">Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku ?? '') }}" placeholder="e.g., TSH-001">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Barcode</label>
                                        <input type="text" name="barcode" class="form-control" value="{{ old('barcode', $product->barcode ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Brand</label>
                                        <select name="brand_id" class="form-select">
                                            <option value="">Select Brand</option>
                                            @foreach($brands ?? [] as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @foreach($category->children ?? [] as $subCat)
                                                    <option value="{{ $subCat->id }}" {{ old('category_id', $product->category_id ?? '') == $subCat->id ? 'selected' : '' }}>&nbsp;&nbsp;– {{ $subCat->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>


                                 


                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_featured" value="0">
                                             <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isFeatured"><strong>Featured Product</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_virtual" value="0">
                                            <input class="form-check-input" type="checkbox" name="is_virtual" value="1" id="isVirtual" {{ old('is_virtual', $product->is_virtual ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isVirtual"><strong>Virtual Product</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="status" value="0">
                                             <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $product->status ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status"><strong>Active</strong></label>
                                        </div>
                                    </div>

                                    <h6 class="mb-2 mt-3 border-top pt-3">Media</h6>
                                    <div class="col-12">
                                        <label class="form-label">Thumbnail Img</label>
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        <div class="text-center mt-2">
                                            <img src="{{ isset($product) && $product->image_url ? $product->image_url : asset('default/noimage.png') }}" class="img-fluid border" id="imagePreview" style="max-height: 120px; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Gallery</label>
                                        <input type="file" name="gallery[]" class="form-control" multiple accept="image/*">
                                        @if(isset($product) && !empty($product->gallery))
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach($product->gallery as $img)
                                                    <div class="gallery-image" style="position:relative;">
                                                        <img src="{{ asset('images/'.$img) }}" width="60" height="60" style="object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                                        <button type="button" class="btn btn-danger btn-sm delete-gallery-image" data-image="{{ $img }}" style="position:absolute; top:-5px; right:-5px; padding: 0 4px; font-size: 10px;"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Video URL</label>
                                        <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $product->video_url ?? '') }}" placeholder="https://youtube.com/watch?v=...">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn"><i class="bi bi-save me-2"></i> {{ isset($product) ? 'Update Product' : 'Create Product' }}</button>
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
        $('#productType').on('change', function() {
            const type = $(this).val();
            $('#groupedSection').toggle(type === 'grouped');
            $('#digitalSection').toggle(type === 'digital');
        });

        let bundleIndex = {{ isset($product) && $product->bundles ? $product->bundles->count() : 0 }};
        $('.addBundle').click(() => {
            $('.bundleDisplay').append(`<div class="row mb-2 bundleItem">
                <div class="col-6"><select name="bundle_products[${bundleIndex}][child_product_id]" class="form-select">
                    <option value="">Select Product</option>
                    @foreach($allProducts ?? [] as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                </select></div>
                <div class="col-4"><input type="number" name="bundle_products[${bundleIndex}][quantity]" class="form-control" value="1" min="1"></div>
                <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeBundle"><i class="bi bi-trash"></i></button></div>
            </div>`);
            bundleIndex++;
        });
        $(document).on('click', '.removeBundle', function() { $(this).closest('.bundleItem').remove(); });

        $('.addFaq').click(() => {
            let idx = Date.now();
            $('.faqsDisplay').append(`<div class="card mb-2 faqItem">
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-11">
                            <input type="text" name="faqs[${idx}][question]" class="form-control mb-2" placeholder="Question">
                            <textarea name="faqs[${idx}][answer]" class="form-control" rows="2" placeholder="Answer"></textarea>
                        </div>
                        <div class="col-1 d-flex align-items-start">
                            <button type="button" class="btn btn-danger btn-sm removeFaq"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>`);
        });
        $(document).on('click', '.removeFaq', function() { $(this).closest('.faqItem').remove(); });

        $(document).on('click', '.delete-gallery-image', function() {
            if (!confirm('Delete this image?')) return;
            var btn = this;
            $.ajax({
                type: 'POST', url: "{{ route('admin.product.delete.gallery') }}",
                data: { image: $(this).data('image'), id: {{ isset($product) ? $product->id : 0 }}, _token: "{{ csrf_token() }}" },
                success: (res) => { toastr.success(res.message); $(btn).closest('.gallery-image').remove(); }
            });
        });

        $('#productForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.product.index") }}'; }, 1500);
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