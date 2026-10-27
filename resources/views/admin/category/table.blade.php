<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td><img src="{{ $category->image_url ?? asset('default/noimage.png') }}" class="rounded" width="50" height="50" style="object-fit: cover;"></td>
                    <td>
                        <strong>{{ $category->name }}</strong><br>
                        <small class="text-muted"><i class="bi bi-link-45deg"></i> {{ $category->slug }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ $category->parent?->name ?? 'Root' }}</span></td>
                    <td>
                        <input type="number" name="order_level" value="{{ $category->order_level }}" data-id="{{ $category->id }}" data-original="{{ $category->order_level }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                    </td>
                    <td>
                        <form class="status-form" data-id="{{ $category->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $category->id }}">
                            <input type="checkbox" {{ $category->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            @if(auth('admin')->user()->hasPermission('category', 'update'))
                                <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            @endif
                            @if(auth('admin')->user()->hasPermission('category', 'delete'))
                                <button type="button" class="btn btn-outline-danger" title="Delete" onclick="confirmDelete(event, 'deleteForm{{ $category->id }}')"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" id="deleteForm{{ $category->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No categories found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $categories->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>