<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Apply On</th>
                    <th>Validity</th>
                    <th>Uses</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($offers as $offer)
                <tr>
                    <td>
                        <strong>{{ $offer->name }}</strong><br>
                        <small class="text-muted">{{ Str::limit($offer->description, 50) }}</small>
                    </td>
                    <td><span class="badge bg-info text-capitalize">{{ str_replace('_', ' ', $offer->offer_type) }}</span></td>
                    <td><span class="badge bg-secondary text-capitalize">{{ str_replace('_', ' ', $offer->apply_on) }}</span></td>
                    <td>
                        @if($offer->start_date || $offer->end_date)
                            <small>{{ $offer->start_date?->format('M d, Y') ?? '∞' }} - {{ $offer->end_date?->format('M d, Y') ?? '∞' }}</small>
                        @else
                            <span class="text-muted">No limit</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $offer->used_count }} / {{ $offer->max_uses ?? '∞' }}</span>
                    </td>
                    <td>
                        <form class="status-form" data-id="{{ $offer->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $offer->id }}">
                            <input type="checkbox" {{ $offer->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            @if(auth('admin')->user()->hasPermission('offer', 'update'))
                                <a href="{{ route('admin.offer.edit', $offer->id) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            @endif
                            @if(auth('admin')->user()->hasPermission('offer', 'delete'))
                                <button type="button" class="btn btn-outline-danger" title="Delete" onclick="confirmDelete(event, 'deleteForm{{ $offer->id }}')"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                        <form action="{{ route('admin.offer.destroy', $offer->id) }}" method="POST" id="deleteForm{{ $offer->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No offers found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($offers->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $offers->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>