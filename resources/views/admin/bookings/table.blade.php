<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="60">#</th>
                    <th>Customer</th>
                    <th>Package</th>
                    <th width="120">Date & People</th>
                    <th width="120">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                    <td>
                        <strong>{{ $booking->name }}</strong>
                        <br><small class="text-muted">{{ $booking->email }}<br>{{ $booking->phone }}</small>
                    </td>
                    <td>
                        <a href="{{ route('admin.package.edit', $booking->package_id) }}" class="text-decoration-none">
                            {{ $booking->package->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td>
                        <div><i class="bi bi-calendar3 me-1"></i> {{ $booking->travel_date ? $booking->travel_date->format('d M, Y') : 'Flexible' }}</div>
                        <small class="text-muted"><i class="bi bi-people me-1"></i> {{ $booking->number_of_people }} Pax</small>
                    </td>
                    <td>
                        <form class="status-form" action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>🏁 Completed</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-outline-info" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" title="Delete" onclick="confirmDelete(event, 'deleteForm{{ $booking->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" id="deleteForm{{ $booking->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No bookings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($bookings->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $bookings->appends(request()->except('page'))->links() }}
    </nav>
    @endif
</div>