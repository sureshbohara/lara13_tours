@extends('layouts.admin.main')

@section('title', 'Manage Bookings')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Bookings" subTitle="Booking List" :breadcrumbItems="['Dashboard', 'Bookings']"/>
    
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-cart-check-fill me-2"></i>Bookings</h6>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">
                @include('admin.bookings.search')
            </div>
            <div class="row">
                @include('admin.bookings.table')
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush