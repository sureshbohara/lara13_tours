@extends('layouts.admin.main')

@section('title', 'Update Profile')

@section('content')
<main class="page-content">
    <x-breadcrumb
        :title="'Profile'"
        :subTitle="'Update Profile'"
        :breadcrumbItems="['Dashboard', 'Profile']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-person-circle me-2"></i>
                Update Your Profile
            </h6>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="updateProfileForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.profile.update') }}">
                @csrf
                <div class="row g-3">
                    {{-- Left Column --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Personal Information</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                               class="form-control text-capitalize @error('name') is-invalid @enderror"
                                               value="{{ old('name', $admin->name ?? '') }}"
                                               placeholder="e.g., John Doe" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="email">Email Address</label>
                                        <input type="email" name="email" id="email"
                                               class="form-control bg-light"
                                               value="{{ $admin->email ?? '' }}" readonly>
                                        <small class="text-muted">Email cannot be changed</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="mobile">Mobile Number</label>
                                        <input type="tel" name="mobile" id="mobile"
                                               class="form-control @error('mobile') is-invalid @enderror"
                                               value="{{ old('mobile', $admin->mobile ?? '') }}"
                                               placeholder="e.g., +1 (555) 123-4567">
                                        @error('mobile') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="address">Address</label>
                                        <textarea name="address" id="address" rows="2"
                                                  class="form-control @error('address') is-invalid @enderror"
                                                  placeholder="Street, City, State, ZIP Code">{{ old('address', $admin->address ?? '') }}</textarea>
                                        @error('address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="details">Details / Bio</label>
                                        <textarea name="details" id="details" rows="3"
                                                  class="form-control @error('details') is-invalid @enderror"
                                                  placeholder="Brief professional bio or notes about yourself...">{{ old('details', $admin->details ?? '') }}</textarea>
                                        @error('details') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Profile Settings</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                            <option value="">-- Select Gender --</option>
                                            <option value="male" {{ old('gender', $admin->gender ?? '') == 'male' ? 'selected' : '' }}>👨 Male</option>
                                            <option value="female" {{ old('gender', $admin->gender ?? '') == 'female' ? 'selected' : '' }}>👩 Female</option>
                                            <option value="other" {{ old('gender', $admin->gender ?? '') == 'other' ? 'selected' : '' }}>⚪ Other</option>
                                        </select>
                                        @error('gender') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Profile Image</label>
                                        <input type="file" name="image" id="profileImageInput"
                                               class="form-control @error('image') is-invalid @enderror"
                                               accept="image/png, image/jpeg, image/webp"
                                               onchange="previewImage(this, 'profileImagePreview')">
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-info-circle me-1"></i>
                                            PNG, JPG or WEBP. Max 2MB. Recommended: 400×400px
                                        </small>
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 text-center">
                                        <img src="{{ $admin->image_url ?? asset('default/noimage.png') }}"
                                             alt="Profile"
                                             id="profileImagePreview"
                                             class="img-fluid rounded border" style="max-height: 150px; width: 150px; object-fit: cover;">
                                    </div>
                                    @if(isset($admin) && $admin->image)
                                        <div class="col-12 text-center">
                                            <small class="text-muted">
                                                <i class="bi bi-check-circle text-success me-1"></i>
                                                Current image: {{ basename($admin->image) }}
                                            </small>
                                        </div>
                                    @endif
                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" id="profileSubmitBtn" class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-save me-2"></i>
                                            <span class="btn-text">Save Changes</span>
                                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                        </button>
                                        <small class="text-muted d-block text-center mt-2">
                                            <i class="bi bi-shield-check me-1"></i>
                                            Changes are saved securely
                                        </small>
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
    $(function () {
        $('#updateProfileForm').on('submit', function(e) {
            e.preventDefault();
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');

            const formData = new FormData(this);
            const submitBtn = $('#profileSubmitBtn');
            const btnText = submitBtn.find('.btn-text');
            const spinner = submitBtn.find('.spinner-border');
            const originalBtnText = btnText.html();

            submitBtn.prop('disabled', true);
            btnText.addClass('d-none');
            spinner.removeClass('d-none');

            $.ajax({
                url: "{{ route('admin.profile.update') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message);
                        if (res.data?.image_url) {
                            $('#profileImagePreview').attr('src', res.data.image_url);
                        }
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const input = $('[name="' + field + '"]');
                            input.addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the form errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                    btnText.removeClass('d-none').html(originalBtnText);
                    spinner.addClass('d-none');
                }
            });
        });
    });

</script>
@endpush