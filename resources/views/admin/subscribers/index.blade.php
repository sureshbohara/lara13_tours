@extends('layouts.admin.main')

@section('title', 'Newsletter Subscribers')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Content & Marketing" subTitle="Subscribers" :breadcrumbItems="['Dashboard', 'Subscribers']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-envelope me-2"></i> Newsletter Subscribers</h6>
            <div>
                <button type="button" class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-upload me-1"></i> Import CSV
                </button>
            </div>
        </div>

        <div class="card-body bg-light p-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

           
            <form method="GET" action="{{ route('admin.subscribers.index') }}" class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by email..." value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ ($filters['status'] ?? '') == '0' ? 'selected' : '' }}>Unsubscribed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-search"></i> Filter</button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary btn-sm text-white"><i class="bi bi-x-circle"></i> Clear</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Email Address</th>
                            <th>Status</th>
                            <th>Subscribed At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscribers as $index => $subscriber)
                            <tr>
                                <td>{{ $subscribers->firstItem() + $index }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>
                                    <form class="status-form" data-id="{{ $subscriber->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $subscriber->id }}">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                {{ $subscriber->status ? 'checked' : '' }} 
                                                onchange="this.form.submit()">
                                        </div>
                                    </form>
                                </td>
                                <td>{{ $subscriber->subscribed_at ? $subscriber->subscribed_at->format('M d, Y') : 'N/A' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this subscriber?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No subscribers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $subscribers->links() }}
            </div>
        </div>
    </div>
</main>


<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.subscribers.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Subscribers (CSV)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Upload a CSV file with a single column named <strong>email</strong>.</p>
                    <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection