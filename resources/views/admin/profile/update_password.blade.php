@extends('layouts.admin.main')

@section('title', 'Update Password')

@section('content')
<main class="page-content">
    <x-breadcrumb
        :title="'Profile'"
        :subTitle="'Update Password'"
        :breadcrumbItems="['Dashboard', 'Password']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white">
            <h6 class="mb-0"><i class="bi bi-key me-2"></i>Update Your Password</h6>
        </div>
        <div class="card-body bg-light p-3">
            <form id="updatePassword" method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                <div class="row g-3">
                    {{-- Left Column: Password Fields --}}
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Password Fields</h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="current_password">Current Password <span class="text-danger">*</span></label>
                                        <input type="password" name="current_password" id="current_password"
                                               class="form-control @error('current_password') is-invalid @enderror"
                                               placeholder="Enter your current password" required>
                                        @error('current_password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="password">New Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Minimum 8 characters" required>
                                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               class="form-control"
                                               placeholder="Re-enter new password" required>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" id="passwordSubmitBtn" class="btn btn-primary w-100">
                                            <i class="bi bi-save me-2"></i>
                                            <span class="btn-text">Save & Update</span>
                                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Password Requirements --}}
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="mb-3">
                                    <i class="bi bi-key me-2"></i>Password Requirements
                                </h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        🔑 Enter your <strong>current password</strong>
                                    </li>
                                    <li class="list-group-item">
                                        🆕 New password must be at least <strong>8 characters</strong>
                                    </li>
                                    <li class="list-group-item">
                                        🔄 Must include letters and numbers
                                    </li>
                                    <li class="list-group-item">
                                        ✅ Confirm by re-typing the new password
                                    </li>
                                    <li class="list-group-item">
                                        ⚠️ New password must be different from current
                                    </li>
                                </ul>
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
        $('#updatePassword').on('submit', function(e) {
            e.preventDefault();
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');

            const submitBtn = $('#passwordSubmitBtn');
            const btnText = submitBtn.find('.btn-text');
            const spinner = submitBtn.find('.spinner-border');
            const originalBtnText = btnText.html();

            submitBtn.prop('disabled', true);
            btnText.addClass('d-none');
            spinner.removeClass('d-none');

            $.ajax({
                url: "{{ route('admin.password.update') }}",
                type: 'POST',
                data: $(this).serialize(),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message);
                        $('#updatePassword')[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            const input = $('[name="' + field + '"]');
                            input.addClass('is-invalid').after('<div class="invalid-feedback d-block">' + messages[0] + '</div>');
                        });
                        toastr.error('Please fix the form errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong. Please try again.');
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