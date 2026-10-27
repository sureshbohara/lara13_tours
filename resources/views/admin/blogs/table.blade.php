<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Title</th>
                    <th>Categories</th>
                    <th width="80">Views</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr>
                    <td><img src="{{ $blog->image_url ?? asset('default/noimage.png') }}" class="rounded" width="50" height="50" style="object-fit: cover;"></td>
                    <td>
                        <strong>{{ $blog->title }}</strong>
                        @if($blog->is_featured) <span class="badge bg-warning text-dark ms-1"><i class="bi bi-star-fill"></i></span> @endif
                        <br><small class="text-muted">{{ $blog->slug }}</small>
                    </td>
                    <td>
                        @foreach($blog->categories->take(2) as $cat)
                            <span class="badge bg-info text-dark">{{ $cat->name }}</span>
                        @endforeach
                        @if($blog->categories->count() > 2)
                            <span class="badge bg-secondary">+{{ $blog->categories->count() - 2 }}</span>
                        @endif
                    </td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-eye"></i> {{ $blog->views }}</span></td>
                    <td>
                        <input type="number" name="order_level" value="{{ $blog->order_level }}" data-id="{{ $blog->id }}" data-original="{{ $blog->order_level }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                    </td>
                    <td>
                        <form class="status-form" data-id="{{ $blog->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $blog->id }}">
                            <input type="checkbox" {{ $blog->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            @if(auth('admin')->user()->hasPermission('blog', 'update'))
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            @endif
                            @if(auth('admin')->user()->hasPermission('blog', 'delete'))
                                <button type="button" class="btn btn-outline-danger" title="Delete" onclick="confirmDelete(event, 'deleteForm{{ $blog->id }}')"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" id="deleteForm{{ $blog->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">No blogs found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($blogs->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $blogs->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>