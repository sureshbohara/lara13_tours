@extends('layouts.admin.main')

@section('title', 'Notifications')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Notifications" subTitle="Your Notifications" :breadcrumbItems="['Dashboard', 'Notifications']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-bell me-2"></i>
                Notifications
                @if($unreadCount > 0)
                    <span class="badge bg-danger ms-2">{{ $unreadCount }} Unread</span>
                @endif
            </h6>
            @if($unreadCount > 0)
                <button type="button" class="btn btn-light btn-sm" id="markAllReadBtn">
                    <i class="bi bi-check2-all me-1"></i> Mark All as Read
                </button>
            @endif
        </div>

        <div class="card-body bg-light p-3">
            @forelse($notifications as $notification)
                <div class="card mb-2 {{ $notification->isUnread() ? 'border-primary' : '' }}" id="notification-{{ $notification->id }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    @if($notification->isUnread())
                                        <span class="badge bg-primary me-2">New</span>
                                    @endif
                                    {{ $notification->title }}
                                </h6>
                                <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="ms-3">
                                @if($notification->isUnread())
                                    <button type="button" class="btn btn-sm btn-outline-primary mark-read-btn" data-id="{{ $notification->id }}">
                                        <i class="bi bi-check"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $notification->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-bell-slash display-1 text-muted"></i>
                    <p class="text-muted mt-3">No notifications yet</p>
                </div>
            @endforelse

            @if($notifications->hasPages())
                <nav class="d-flex justify-content-center mt-4">
                    {{ $notifications->links() }}
                </nav>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.mark-read-btn').on('click', function() {
        const id = $(this).data('id');
        const card = $(`#notification-${id}`);
        
        $.ajax({
            url: `/admin/notifications/${id}/read`,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                toastr.success(response.message);
                card.removeClass('border-primary').find('.badge.bg-primary').remove();
                $(`.mark-read-btn[data-id="${id}"]`).remove();
                updateUnreadCount();
            }
        });
    });

    // Mark all as read
    $('#markAllReadBtn').on('click', function() {
        $.ajax({
            url: '/admin/notifications/mark-all-read',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                toastr.success(response.message);
                location.reload();
            }
        });
    });

    // Delete notification
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        
        if (!confirm('Delete this notification?')) return;
        
        $.ajax({
            url: `/admin/notifications/${id}`,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                toastr.success(response.message);
                $(`#notification-${id}`).fadeOut();
                updateUnreadCount();
            }
        });
    });

    function updateUnreadCount() {
        $.get('/admin/notifications/unread-count', function(data) {
            const badge = $('.badge.bg-danger');
            if (data.count === 0) {
                badge.remove();
            } else {
                badge.text(data.count + ' Unread');
            }
        });
    }
});
</script>
@endpush