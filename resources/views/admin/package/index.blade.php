@extends('layouts.admin.main')

@section('title', 'Manage Packages')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Packages" subTitle="Package List" :breadcrumbItems="['Dashboard', 'Packages']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-briefcase me-2"></i> Tour Packages</h6>
            @if(auth('admin')->user()->hasPermission('package', 'create'))
                <a href="{{ route('admin.package.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-lg"></i> Create New
                </a>
            @endif
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.package.search')</div>
            <div class="row">@include('admin.package.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.package.status") }}', 'Package status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.package.order-level") }}', 'Package order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush