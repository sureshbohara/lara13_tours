@extends('layouts.admin.main')
@section('title', 'Manage Categories')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Categories" subTitle="Category List" :breadcrumbItems="['Dashboard', 'Categories']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-folder me-2"></i>Categories</h6>
            @if(auth('admin')->user()->hasPermission('category', 'create'))
                <a href="{{ route('admin.category.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
            @endif
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.category.search')</div>
            <div class="row">@include('admin.category.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.category.toggleStatus") }}', 'Category status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.category.updateOrderLevel") }}', 'Category order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush