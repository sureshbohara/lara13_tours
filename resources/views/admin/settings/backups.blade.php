@extends('layouts.admin.main')

@section('title', 'Database Backups')

@section('content')
<main class="page-content">
    <x-breadcrumb title="System" subTitle="Database Backups" :breadcrumbItems="['Dashboard', 'Backups']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-database me-2"></i> Database Backups</h6>
            <form action="{{ route('admin.backups.store') }}" method="POST" id="createBackupForm">
                @csrf
                <button type="submit" class="btn btn-light btn-sm" id="backupBtn">
                    <i class="bi bi-plus-circle me-1"></i> Create New Backup
                </button>
            </form>
        </div>

        <div class="card-body bg-light p-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Size</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $index => $backup)
                            <tr>
                                <td>{{ $backups->firstItem() + $index }}</td>
                                <td><i class="bi bi-file-earmark-zip text-primary me-2"></i>{{ $backup->file_name }}</td>
                                <td><span class="badge bg-info">{{ $backup->file_size }}</span></td>
                                <td>{{ $backup->creator->name ?? 'Unknown' }}</td>
                                <td>{{ $backup->created_at->format('M d, Y h:i A') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.backups.download', $backup->id) }}" class="btn btn-outline-primary" title="Download">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <form action="{{ route('admin.backups.destroy', $backup->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this backup?');">
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
                                <td colspan="6" class="text-center py-4 text-muted">No backups found. Create your first backup!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $backups->links() }}
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $('#createBackupForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#backupBtn');
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Creating Backup...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                toastr.success(res.message);
                setTimeout(() => window.location.reload(), 1500);
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i> Create New Backup');
                toastr.error('Failed to create backup.');
            }
        });
    });
</script>
@endpush