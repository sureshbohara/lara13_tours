<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td><img src="{{ $item->image_url ?? asset('default/noimage.png') }}" class="rounded" width="50" height="50" style="object-fit: cover;"></td>
                    <td><strong>{{ $item->title }}</strong></td>
                    <td><code>{{ $item->slug }}</code></td>
                    <td>
                        <input type="number" name="order_level" value="{{ $item->order_level }}" data-id="{{ $item->id }}" data-original="{{ $item->order_level }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                    </td>
                    <td>
                        <form class="status-form" data-id="{{ $item->id }}">
                            @csrf <input type="hidden" name="status_id" value="{{ $item->id }}">
                            <input type="checkbox" {{ $item->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            @if(auth('admin')->user()->hasPermission('page', 'update'))
                                <a href="{{ route('admin.page.edit', $item->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            @endif
                            @if(auth('admin')->user()->hasPermission('page', 'delete'))
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $item->id }}')"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                        <form action="{{ route('admin.page.destroy', $item->id) }}" method="POST" id="deleteForm{{ $item->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No pages found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $items->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>