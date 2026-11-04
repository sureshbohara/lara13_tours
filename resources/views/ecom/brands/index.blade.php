@extends('layouts.admin.main')
@section('title', 'Manage Brands')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Brands" subTitle="Brand List" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Brands']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-bookmark-star me-2"></i>Brands</h6>
            @if(auth('admin')->user()->hasPermission('brand', 'create'))
                <a href="{{ route('admin.brand.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
            @endif
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('ecom.brands.search')</div>
            <div class="row">@include('ecom.brands.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.brand.status") }}', 'Brand status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.brand.order-level") }}', 'Brand order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush