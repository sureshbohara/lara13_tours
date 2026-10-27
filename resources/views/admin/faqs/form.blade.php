@extends('layouts.admin.main')

@section('title', isset($faq) ? 'Edit FAQ' : 'Create FAQ')

@section('content')
<main class="page-content">
    <x-breadcrumb title="FAQs" subTitle="{{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}" :breadcrumbItems="['Dashboard', 'FAQs']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-question-circle me-2"></i>
                {{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}
            </h6>
            <a href="{{ route('admin.faq.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="faqForm" method="POST" action="{{ isset($faq) ? route('admin.faq.update', $faq->id) : route('admin.faq.store') }}">
                @csrf
                @if(isset($faq))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    {{-- Left Column: FAQ Details --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">FAQ Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="question">Question <span class="text-danger">*</span></label>
                                        <textarea name="question" id="question" rows="3" class="form-control @error('question') is-invalid @enderror" placeholder="e.g., How do I book a property?" required>{{ old('question', isset($faq) ? $faq->question : '') }}</textarea>
                                        @error('question') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="answer">Answer <span class="text-danger">*</span></label>
                                        <textarea name="answer" id="answer" rows="6" class="form-control editor @error('answer') is-invalid @enderror" placeholder="Enter the detailed answer here..." required>{{ old('answer', isset($faq) ? $faq->answer : '') }}</textarea>
                                        @error('answer') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Settings --}}
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="display_on">Display On <span class="text-danger">*</span></label>
                                        @php
                                            $currentDisplayOn = old('display_on', isset($faq) ? $faq->display_on : 'general');
                                        @endphp
                                        <select name="display_on" id="display_on" class="form-select @error('display_on') is-invalid @enderror" required>
                                            <option value="general" {{ $currentDisplayOn == 'general' ? 'selected' : '' }}>General</option>
                                            <option value="home" {{ $currentDisplayOn == 'home' ? 'selected' : '' }}>Home</option>
                                            <option value="host" {{ $currentDisplayOn == 'host' ? 'selected' : '' }}>Host</option>
                                            <option value="guest" {{ $currentDisplayOn == 'guest' ? 'selected' : '' }}>Guest</option>
                                            <option value="default" {{ $currentDisplayOn == 'default' ? 'selected' : '' }}>Default</option>
                                        </select>
                                        @error('display_on') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label" for="order_level">Display Order</label>
                                        <input type="number" name="order_level" id="order_level" min="0" class="form-control @error('order_level') is-invalid @enderror" value="{{ old('order_level', isset($faq) ? $faq->order_level : '0') }}" placeholder="0 = Highest priority">
                                        @error('order_level') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status', isset($faq) ? $faq->status : 1) == 1 ? 'selected' : '' }}>✅ Active</option>
                                            <option value="0" {{ old('status', isset($faq) ? $faq->status : 1) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                                            <i class="bi bi-save me-2"></i>
                                            {{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}
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
        $('#faqForm').on('submit', function(e) {
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
                        window.location.href = '{{ route("admin.faq.index") }}'; 
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