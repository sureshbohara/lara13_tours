@extends('layouts.admin.main')

@section('title', isset($team) ? 'Edit Team' : 'Create Team')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Team" subTitle="{{ isset($team) ? 'Update Team Member' : 'Create Team Member' }}" :breadcrumbItems="['Dashboard', 'Team']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-people me-2"></i>
                {{ isset($team) ? 'Update Team Member' : 'Create Team Member' }}
            </h6>
            <a href="{{ route('admin.team.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="teamForm" method="POST" enctype="multipart/form-data" action="{{ isset($team) ? route('admin.team.update', $team->id) : route('admin.team.store') }}">
                @csrf
                @if(isset($team))
                    @method('PUT')
                @endif

                <div class="row g-3">
        
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Personal Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($team) ? $team->name : '') }}" placeholder="e.g., Rajesh Shrestha" required>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="email">Email Address</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($team) ? $team->email : '') }}" placeholder="e.g., rajesh@example.com">
                                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', isset($team) ? $team->address : '') }}" placeholder="e.g., Kathmandu, Nepal">
                                        @error('address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="bio">Bio / Description</label>
                                        <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror" placeholder="Brief introduction about the team member's experience and role...">{{ old('bio', isset($team) ? $team->bio : '') }}</textarea>
                                        @error('bio') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary"><i class="bi bi-share me-2"></i>Social Media Links</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="facebook">Facebook</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-primary text-white"><i class="bi bi-facebook"></i></span>
                                                    <input type="url" name="facebook" id="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', isset($team) ? $team->facebook : '') }}" placeholder="https://facebook.com/username">
                                                </div>
                                                @error('facebook') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="instagram">Instagram</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-danger text-white"><i class="bi bi-instagram"></i></span>
                                                    <input type="url" name="instagram" id="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', isset($team) ? $team->instagram : '') }}" placeholder="https://instagram.com/username">
                                                </div>
                                                @error('instagram') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="youtube">YouTube</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-danger text-white"><i class="bi bi-youtube"></i></span>
                                                    <input type="url" name="youtube" id="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ old('youtube', isset($team) ? $team->youtube : '') }}" placeholder="https://youtube.com/@channel">
                                                </div>
                                                @error('youtube') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="tiktok">TikTok</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-dark text-white"><i class="bi bi-tiktok"></i></span>
                                                    <input type="url" name="tiktok" id="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ old('tiktok', isset($team) ? $team->tiktok : '') }}" placeholder="https://tiktok.com/@username">
                                                </div>
                                                @error('tiktok') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings & Profile</h5>
                                <div class="row g-3">
                                    
                                <div class="col-12">
                                    <label class="form-label" for="designation">Designation / Role <span class="text-danger">*</span></label>
                                    
                                    @php
                                        $designations = [
                                            'Founder & CEO',
                                            'Managing Director',
                                            'Head of Operations',
                                            'Chief Technology Officer',
                                            'Marketing Director',
                                            'Senior Trekking Coordinator',
                                            'Customer Experience Manager',
                                            'Regional Operations Manager',
                                            'Finance Manager',
                                            'Senior Mountain Guide',
                                            'Other'
                                        ];
                                        $currentDesig = old('designation', $team->designation ?? '');
                                    @endphp

                                    <select name="designation" id="designation" class="form-select @error('designation') is-invalid @enderror" required>
                                        <option value="">Select Designation</option>
                                        @foreach($designations as $desig)
                                            <option value="{{ $desig }}" {{ $currentDesig == $desig ? 'selected' : '' }}>
                                                {{ $desig }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    @error('designation') 
                                        <div class="invalid-feedback d-block">{{ $message }}</div> 
                                    @enderror
                                </div>

                                    <div class="col-12">
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($team) ? $team->order_level : '0') }}" placeholder="0 = Highest priority">
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', isset($team) ? $team->status : 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', isset($team) ? $team->status : 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="image">Profile Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 text-center mb-2">
                                        <img src="{{ isset($team) && $team->image_url ? $team->image_url : asset('default/noimage.png') }}" id="imagePreview" class="img-fluid rounded-circle border" style="max-height: 150px; width: 150px; object-fit: cover;">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i>
                                            {{ isset($team) ? 'Update Team Member' : 'Create Team Member' }}
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
        $('#teamForm').on('submit', function(e) {
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
                        window.location.href = '{{ route("admin.team.index") }}'; 
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