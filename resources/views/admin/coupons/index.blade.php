@extends('layouts.admin.main')

@section('title', 'Coupons & Discounts')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Marketing" subTitle="Coupons" :breadcrumbItems="['Dashboard', 'Coupons']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i> Coupons & Discounts</h6>
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Create Coupon
            </a>
        </div>

        <div class="card-body bg-light p-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

         
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Search by code or description..." value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="percentage" {{ ($filters['type'] ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ ($filters['type'] ?? '') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ ($filters['status'] ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn-sm w-100 text-white">Clear</a>
                </div>
            </form>

            
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Usage</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $coupon->code }}</strong>
                                @if($coupon->description)
                                    <br><small class="text-muted">{{ Str::limit($coupon->description, 40) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $coupon->type === 'percentage' ? 'info' : 'warning' }}">
                                    {{ ucfirst($coupon->type) }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $coupon->formatted_value }}</strong>
                                @if($coupon->min_order_amount)
                                    <br><small class="text-muted">Min: ${{ number_format($coupon->min_order_amount, 2) }}</small>
                                @endif
                                @if($coupon->max_discount)
                                    <br><small class="text-muted">Max: ${{ number_format($coupon->max_discount, 2) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $coupon->used_count }}</span>
                                @if($coupon->usage_limit)
                                    <small class="text-muted">/ {{ $coupon->usage_limit }}</small>
                                @else
                                    <small class="text-muted">/ ∞</small>
                                @endif
                            </td>
                            <td>
                                <small>
                                    <div>{{ $coupon->start_date->format('M d, Y') }}</div>
                                    <div class="text-muted">
                                        to {{ $coupon->end_date ? $coupon->end_date->format('M d, Y') : 'No expiry' }}
                                    </div>
                                </small>
                            </td>
                            <td>
                                <form class="status-form" data-id="{{ $coupon->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $coupon->id }}">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                            {{ $coupon->status ? 'checked' : '' }} 
                                            onchange="this.form.submit()">
                                    </div>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-ticket-perforated display-1 d-block mb-2"></i>
                                <h5>No coupons found</h5>
                                <p>Create your first coupon to start offering discounts!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($coupons->hasPages())
                <div class="mt-3">{{ $coupons->links() }}</div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Status toggle AJAX
    $('.status-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const id = form.data('id');
        
        $.ajax({
            url: '{{ route("admin.coupons.toggleStatus") }}',
            type: 'POST',
            data: form.serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                toastr.success(res.message);
            },
            error: function() {
                toastr.error('Failed to update status');
            }
        });
    });
</script>
@endpush