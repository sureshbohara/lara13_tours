@extends('layouts.admin.main')

@section('title', isset($admin) ? 'Edit Admin' : 'Create Admin')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Admins" subTitle="{{ isset($admin) ? 'Update Admin' : 'Create Admin' }}" :breadcrumbItems="['Dashboard', 'Admins']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-person-badge me-2"></i>
                {{ isset($admin) ? 'Update Admin' : 'Create Admin' }}
            </h6>
            <a href="{{ route('admin.user.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="adminForm" method="POST" enctype="multipart/form-data" action="{{ isset($admin) ? route('admin.user.update', $admin->id) : route('admin.user.store') }}">
                @csrf
                @if(isset($admin))
                    @method('PUT')
                @endif

                <div class="row g-3">
                  
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Admin Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control text-capitalize @error('name') is-invalid @enderror" value="{{ old('name', isset($admin) ? $admin->name : '') }}" placeholder="e.g., John Doe" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($admin) ? $admin->email : '') }}" placeholder="admin@example.com" required>
                                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="mobile">Mobile Number</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile', isset($admin) ? $admin->mobile : '') }}" placeholder="+977-98XXXXXXXX">
                                        @error('mobile') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="password">{{ isset($admin) ? 'New Password (Leave blank to keep current)' : 'Password *' }}</label>
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min 8 characters" {{ !isset($admin) ? 'required' : '' }}>
                                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="password_confirmation">{{ isset($admin) ? 'Confirm New Password' : 'Confirm Password *' }}</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-enter password" {{ !isset($admin) ? 'required' : '' }}>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', isset($admin) ? $admin->address : '') }}" placeholder="Enter residential address">
                                        @error('address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="details">Additional Details</label>
                                        <textarea name="details" id="details" rows="3" class="form-control @error('details') is-invalid @enderror" placeholder="Any additional notes or information...">{{ old('details', isset($admin) ? $admin->details : '') }}</textarea>
                                        @error('details') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                        <label class="form-label" for="role_id">User Role <span class="text-danger">*</span></label>
                                        <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                            <option value="">-- Select Role --</option>
                                            @foreach($roles as $id => $name)
                                                <option value="{{ $id }}" {{ old('role_id', isset($admin) ? $admin->role_id : '') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                            <option value="">-- Select Gender --</option>
                                            <option value="male" {{ old('gender', isset($admin) ? $admin->gender : '') == 'male' ? 'selected' : '' }}>👨 Male</option>
                                            <option value="female" {{ old('gender', isset($admin) ? $admin->gender : '') == 'female' ? 'selected' : '' }}>👩 Female</option>
                                            <option value="other" {{ old('gender', isset($admin) ? $admin->gender : '') == 'other' ? 'selected' : '' }}>⚪ Other</option>
                                        </select>
                                        @error('gender') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($admin) ? $admin->order_level : '0') }}" placeholder="0 = Highest priority">
                                        <small class="text-muted">Lower numbers display first</small>
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="image">Profile Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($admin) && $admin->image_url ? $admin->image_url : asset('default/noimage.png') }}" alt="Profile Preview" class="img-fluid" id="imagePreview">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i>
                                            {{ isset($admin) ? 'Update Admin' : 'Create Admin' }}
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
        $('#adminForm').on('submit', function(e) {
            e.preventDefault();
            
           
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            const formData = new FormData(this);
            const submitBtn = $('#submitBtn');
            
          
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
                        window.location.href = '{{ route("admin.user.index") }}'; 
                    }, 1500);
                },
                error: function(xhr) {
                   
                    submitBtn.prop('disabled', false);
                    
                 
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