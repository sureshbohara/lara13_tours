@extends('layouts.admin.main')
@section('title', 'Manage Blogs')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Blogs" subTitle="Blog List" :breadcrumbItems="['Dashboard', 'Blogs']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-journal-text me-2"></i>Blogs</h6>
            @if(auth('admin')->user()->hasPermission('blog', 'create'))
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
            @endif
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.blogs.search')</div>
            <div class="row">@include('admin.blogs.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.blogs.toggleStatus") }}', 'Blog status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.blogs.updateOrderLevel") }}', 'Blog order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush