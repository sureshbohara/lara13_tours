@extends('layouts.admin.main')

@section('title', isset($package) ? 'Edit Package' : 'Create Package')

@section('content')
<main class="page-content">
  <x-breadcrumb title="Packages" subTitle="{{ isset($package) ? 'Update Package' : 'Create Package' }}" :breadcrumbItems="['Dashboard', 'Packages']" />

  <div class="card mb-4">
    <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
      <h6 class="mb-0"><i class="bi bi-briefcase me-2"></i> {{ isset($package) ? 'Update Package' : 'Create Package' }}</h6>
      <a href="{{ route('admin.package.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card-body bg-light p-3">
      <form id="packageForm" method="POST" enctype="multipart/form-data" action="{{ isset($package) ? route('admin.package.update', $package->id) : route('admin.package.store') }}">
        @csrf
        @if(isset($package)) @method('PUT') @endif

        <div class="row g-3">

          <div class="col-lg-8">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <h5 class="card-title mb-3 border-bottom pb-2">Package Details</h5>
                <div class="row g-3">

                  <div class="col-12">
                    <label class="form-label" for="name">Package Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($package) ? $package->name : '') }}" placeholder="e.g., Everest Base Camp Trek" required>
                    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>

                  <div class="col-12">
                    <label class="form-label" for="description">Short Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control editor @error('description') is-invalid @enderror" placeholder="Brief overview of the package...">{{ old('description', isset($package) ? $package->description : '') }}</textarea>
                    @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>

                  <div class="col-12">
                    <label class="form-label" for="content">Full Content</label>
                    <textarea name="content" id="content" rows="6" class="form-control editor @error('content') is-invalid @enderror" placeholder="Detailed package information...">{{ old('content', isset($package) ? $package->content : '') }}</textarea>
                    @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>



                  <div class="col-12 mt-4 pt-3 border-top">
                    <h6 class="mb-3 text-primary"><i class="bi bi-info-circle me-2"></i>Trip Facts</h6>
                    <div class="row g-3">

                      <div class="col-md-4">
                        <label class="form-label" for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', isset($package) ? $package->duration : '') }}" placeholder="e.g., 14 Days">
                        @error('duration') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" for="max_altitude">Max Altitude</label>
                        <input type="text" name="max_altitude" id="max_altitude" class="form-control @error('max_altitude') is-invalid @enderror" value="{{ old('max_altitude', isset($package) ? $package->max_altitude : '') }}" placeholder="e.g., 5,545m">
                        @error('max_altitude') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" for="best_season">Best Season</label>
                        <input type="text" name="best_season" id="best_season" class="form-control @error('best_season') is-invalid @enderror" value="{{ old('best_season', isset($package) ? $package->best_season : '') }}" placeholder="e.g., Mar - May">
                        @error('best_season') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" for="meals">Meals</label>
                        <input type="text" name="meals" id="meals" class="form-control @error('meals') is-invalid @enderror" value="{{ old('meals', isset($package) ? $package->meals : '') }}" placeholder="e.g., B/L/D">
                        @error('meals') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" for="accommodation">Accommodation</label>
                        <input type="text" name="accommodation" id="accommodation" class="form-control @error('accommodation') is-invalid @enderror" value="{{ old('accommodation', isset($package) ? $package->accommodation : '') }}" placeholder="e.g., Tea House">
                        @error('accommodation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" for="transportation">Transportation</label>
                        <input type="text" name="transportation" id="transportation" class="form-control @error('transportation') is-invalid @enderror" value="{{ old('transportation', isset($package) ? $package->transportation : '') }}" placeholder="e.g., Flight">
                        @error('transportation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-12">
                        <label class="form-label" for="trip_grading">Trip Grading</label>
                        <input type="text" name="trip_grading" id="trip_grading" class="form-control @error('trip_grading') is-invalid @enderror" value="{{ old('trip_grading', isset($package) ? $package->trip_grading : '') }}" placeholder="e.g., Moderate">
                        @error('trip_grading') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                    </div>
                  </div>


                  <div class="col-12 mt-4 pt-3 border-top">
                    <h6 class="mb-3 text-primary"><i class="bi bi-star me-2"></i>Trip Highlights</h6>
                    <div class="featureDisplay">
                      @if(isset($package) && is_array($package->highlight_key))
                      @foreach($package->highlight_key as $highlight)
                      <div class="row featureItem mb-2">
                        <div class="col-10"><input type="text" name="highlight_key[]" class="form-control" value="{{ $highlight }}" placeholder="Highlight point"></div>
                        <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeFeature"><i class="bi bi-trash"></i></button></div>
                      </div>
                      @endforeach
                      @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm addFeatures"><i class="bi bi-plus-circle"></i> Add Highlight</button>
                  </div>


                  <div class="col-12 mt-4 pt-3 border-top">
                    <h6 class="mb-3 text-primary"><i class="bi bi-compass me-2"></i>Travel Styles / Activities</h6>
                    <p class="text-muted small mb-3">Select activities that apply to this package.</p>
                    <div class="row g-3">
                      @php $activities = ['Trekking', 'Camping', 'Tea House', 'Luxury', 'Cultural', 'Adventure', 'Photography', 'Wildlife']; @endphp
                      @foreach($activities as $activity)
                      <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="activities[]" id="act_{{ $loop->index }}" value="{{ $activity }}" {{ in_array($activity, old('activities', isset($package) && is_array($package->activities) ? $package->activities : [])) ? 'checked' : '' }}>
                          <label class="form-check-label" for="act_{{ $loop->index }}">{{ $activity }}</label>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>


                  <div class="col-12 mt-4 pt-3 border-top">
                    <h6 class="mb-3 text-primary"><i class="bi bi-question-circle me-2"></i>Frequently Asked Questions</h6>
                    <div class="faqsDisplay">
                      @if(isset($package) && is_array($package->faqs))
                      @foreach($package->faqs as $index => $faq)
                      <div class="card mb-2 faqsConfiguration">
                        <div class="card-body p-2">
                          <div class="row">
                            <div class="col-11">
                              <input type="text" name="faqs[{{ $index }}][label]" class="form-control mb-2" placeholder="Question" value="{{ $faq['label'] ?? '' }}">
                              <textarea name="faqs[{{ $index }}][detail]" class="form-control" rows="2" placeholder="Answer">{{ $faq['detail'] ?? '' }}</textarea>
                            </div>
                            <div class="col-1 d-flex align-items-start">
                              <button type="button" class="btn btn-danger btn-sm removeFaqs"><i class="bi bi-trash"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm addFaqs"><i class="bi bi-plus-circle"></i> Add FAQ</button>
                  </div>


                  <div class="col-12 mt-4 pt-3 border-top">
                    <h6 class="mb-3 text-primary"><i class="bi bi-search me-2"></i>SEO Settings</h6>
                    <div class="row g-3">

                      <div class="col-12">
                        <label class="form-label" for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', isset($package) ? $package->meta_title : '') }}" placeholder="SEO optimized title">
                        @error('meta_title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-12">
                        <label class="form-label" for="meta_keywords">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords', isset($package) ? $package->meta_keywords : '') }}" placeholder="keyword1, keyword2">
                        @error('meta_keywords') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-12">
                        <label class="form-label" for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Brief description for search engines...">{{ old('meta_description', isset($package) ? $package->meta_description : '') }}</textarea>
                        @error('meta_description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-4">

            <div class="card shadow-sm mb-3">
              <div class="card-body">
                <h5 class="card-title mb-3 border-bottom pb-2">Categories</h5>
                <div class="scrollable-container mb-3 p-2" style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem;">
                  @php $selectedCats = old('category_id', isset($package) ? $package->categories->pluck('id')->toArray() : []); @endphp
                  @foreach($getCategories as $category)
                  <div class="form-check mb-1">
                    <input type="checkbox" class="form-check-input" name="category_id[]" id="cat-{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, $selectedCats) ? 'checked' : '' }}>
                    <label class="form-check-label" for="cat-{{ $category->id }}">{{ $category->name }}</label>
                  </div>
                  @foreach($category->children as $subCat)
                  <div class="form-check ms-3 mb-1">
                    <input type="checkbox" class="form-check-input" name="category_id[]" id="subcat-{{ $subCat->id }}" value="{{ $subCat->id }}" {{ in_array($subCat->id, $selectedCats) ? 'checked' : '' }}>
                    <label class="form-check-label" for="subcat-{{ $subCat->id }}">– {{ $subCat->name }}</label>
                  </div>
                  @endforeach
                  @endforeach
                </div>

                <label class="form-label" for="excerpt">Short Excerpt</label>
                <textarea name="excerpt" id="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Brief summary...">{{ old('excerpt', isset($package) ? $package->excerpt : '') }}</textarea>
                @error('excerpt') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="card shadow-sm mb-3">
              <div class="card-body">
                <h5 class="card-title mb-3 border-bottom pb-2">Pricing</h5>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label" for="trip_previous_price">Previous Price</label>
                    <input type="number" name="trip_previous_price" id="trip_previous_price" step="0.01" class="form-control @error('trip_previous_price') is-invalid @enderror" value="{{ old('trip_previous_price', isset($package) ? $package->trip_previous_price : '') }}" placeholder="0.00">
                    @error('trip_previous_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="trip_price">Current Price</label>
                    <input type="number" name="trip_price" id="trip_price" step="0.01" class="form-control @error('trip_price') is-invalid @enderror" value="{{ old('trip_price', isset($package) ? $package->trip_price : '') }}" placeholder="0.00">
                    @error('trip_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>
                </div>
                <div class="col-12 mt-3 pt-3 border-top">
                  <h6 class="mb-3">Group Size Pricing</h6>
                  <div class="groupPrice">
                    @if(isset($package) && is_array($package->group_size_price))
                    @foreach($package->group_size_price as $index => $price)
                    <div class="row mb-2 groupKeyRow">
                      <div class="col-5"><input type="text" name="group_size_price[{{ $index }}][label]" class="form-control form-control-sm" placeholder="1-5 pax" value="{{ $price['label'] ?? '' }}"></div>
                      <div class="col-5"><input type="number" step="0.01" name="group_size_price[{{ $index }}][price]" class="form-control form-control-sm" placeholder="999.99" value="{{ $price['price'] ?? '' }}"></div>
                      <div class="col-2"><button type="button" class="btn btn-danger btn-sm removePriceKey"><i class="bi bi-trash"></i></button></div>
                    </div>
                    @endforeach
                    @endif
                  </div>
                  <button type="button" class="btn btn-outline-primary btn-sm addPriceBtn"><i class="bi bi-plus-circle"></i> Add Group Price</button>
                </div>
              </div>
            </div>

            <div class="card shadow-sm mb-3">
              <div class="card-body">
                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label" for="order_level">Display Order</label>
                    <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($package) ? $package->order_level : '0') }}" placeholder="0 = Highest priority">
                    @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="display_on">Display On</label>
                    <select name="display_on" id="display_on" class="form-select @error('display_on') is-invalid @enderror">
                      <option value="">Select Location</option>
                      <option value="default" {{ old('display_on', isset($package) ? $package->display_on : '') == 'default' ? 'selected' : '' }}>Default</option>
                      <option value="header" {{ old('display_on', isset($package) ? $package->display_on : '') == 'header' ? 'selected' : '' }}>Header</option>
                      <option value="footer" {{ old('display_on', isset($package) ? $package->display_on : '') == 'footer' ? 'selected' : '' }}>Footer</option>
                      <option value="sidebar" {{ old('display_on', isset($package) ? $package->display_on : '') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                    </select>
                    @error('display_on') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>
                </div>
              </div>
            </div>

            <div class="card shadow-sm mb-3">
              <div class="card-body">
                <h5 class="card-title mb-3 border-bottom pb-2">Media</h5>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label" for="image">List Image</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                    @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <div class="text-center mt-2"><img src="{{ isset($package) && $package->image_url ? $package->image_url : asset('default/noimage.png') }}" class="img-fluid border rounded" id="imagePreview" style="max-height: 100px; width: 100%; object-fit: cover;"></div>
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="feature_image">Feature Image</label>
                    <input type="file" name="feature_image" id="feature_image" class="form-control @error('feature_image') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'featureImagePreview')">
                    @error('feature_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <div class="text-center mt-2"><img src="{{ isset($package) && $package->feature_image_url ? $package->feature_image_url : asset('default/noimage.png') }}" class="img-fluid border rounded" id="featureImagePreview" style="max-height: 100px; width: 100%; object-fit: cover;"></div>
                  </div>
                  <div class="col-12 mt-3 pt-3 border-top">
                    <label class="form-label" for="gallery">Gallery</label>
                    <input type="file" name="gallery[]" id="gallery" class="form-control @error('gallery') is-invalid @enderror" multiple accept="image/*">
                    @error('gallery') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>


                  @if(isset($package) && is_array($package->gallery) && !empty($package->gallery))
                  <div class="col-12">
                    <label class="form-label small text-muted">Current Gallery:</label>
                    <div class="d-flex flex-wrap gap-2 mt-1">
                      @foreach($package->gallery as $img)
                      <div class="gallery-image" style="position:relative; display:inline-block;">
                        <img src="{{ asset('images/' . $img) }}" width="60" height="60" style="object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">

                        <button type="button" class="btn btn-danger btn-sm delete-gallery-image" data-image="{{ $img }}" style="position:absolute; top:-5px; right:-5px; padding: 0 4px; font-size: 10px; line-height: 1.2;">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  @endif


                </div>
              </div>
            </div>

            <div class="col-12 mt-4 pt-2 border-top">
              <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                <i class="bi bi-save me-2"></i> {{ isset($package) ? 'Update Package' : 'Create Package' }}
              </button>
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
    // Gallery Delete
    $(document).on('click', '.delete-gallery-image', function() {
      if (!confirm('Delete this image?')) return;
      var btn = this;
      $.ajax({
        type: 'POST',
        url: "{{ route('admin.package.delete.gallery.image') }}",
        data: {
          image: $(this).data('image'),
           id: {{ isset($package) ? $package->id : 0 }},
          _token: "{{ csrf_token() }}"
        },
        success: (res) => {
          if (res.status === 200) {
            toastr.success(res.message);
            $(btn).closest('.gallery-image').remove();
          } else toastr.error(res.message);
        }
      });
    });

    // Highlights
    $('.addFeatures').click(() => $('.featureDisplay').append(`<div class="row featureItem mb-2"><div class="col-10"><input type="text" name="highlight_key[]" class="form-control" placeholder="Highlight"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removeFeature"><i class="bi bi-trash"></i></button></div></div>`));
    $(document).on('click', '.removeFeature', function() {
      $(this).closest('.featureItem').remove();
    });

    // FAQs
    $('.addFaqs').click(() => {
      let idx = Date.now();
      $('.faqsDisplay').append(`<div class="card mb-2 faqsConfiguration"><div class="card-body p-2"><div class="row"><div class="col-11"><input type="text" name="faqs[${idx}][label]" class="form-control mb-2" placeholder="Question"><textarea name="faqs[${idx}][detail]" class="form-control" rows="2" placeholder="Answer"></textarea></div><div class="col-1 d-flex align-items-start"><button type="button" class="btn btn-danger btn-sm removeFaqs"><i class="bi bi-trash"></i></button></div></div></div></div>`);
    });
    $(document).on('click', '.removeFaqs', function() {
      $(this).closest('.faqsConfiguration').remove();
    });

    // Group Pricing
    $('.addPriceBtn').click(() => {
      let idx = Date.now();
      $('.groupPrice').append(`<div class="row mb-2 groupKeyRow"><div class="col-5"><input type="text" name="group_size_price[${idx}][label]" class="form-control form-control-sm" placeholder="1-5 pax"></div><div class="col-5"><input type="number" step="0.01" name="group_size_price[${idx}][price]" class="form-control form-control-sm" placeholder="999.99"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removePriceKey"><i class="bi bi-trash"></i></button></div></div>`);
    });
    $(document).on('click', '.removePriceKey', function() {
      $(this).closest('.groupKeyRow').remove();
    });

    // Form Submit
    $('#packageForm').on('submit', function(e) {
      e.preventDefault();
      $('.invalid-feedback').remove();
      $('.is-invalid').removeClass('is-invalid');

      const formData = new FormData(this);
      const submitBtn = $('#submitBtn');
      const originalText = submitBtn.html();

      submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');

      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (res) => {
          toastr.success(res.message);
          setTimeout(() => window.location.href = '{{ route("admin.package.index") }}', 1000);
        },
        error: (xhr) => {
          submitBtn.prop('disabled', false).html(originalText);
          if (xhr.responseJSON?.errors) {
            $.each(xhr.responseJSON.errors, (field, errors) => {
              $('[name="' + field + '"], [name="' + field + '[]"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
            });
            toastr.error('Please fix the errors');
          } else {
            toastr.error('Something went wrong');
          }
        }
      });
    });
  });
</script>
@endpush