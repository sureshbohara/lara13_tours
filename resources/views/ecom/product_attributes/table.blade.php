<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Values Count</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attributes as $attribute)
                <tr>

                    <td>
                        <strong>{{ $attribute->name }}</strong><br>
                        <small class="text-muted">{{ $attribute->slug }}</small>
                    </td>

                    <td><span class="badge bg-info text-capitalize">{{ $attribute->type }}</span></td>

                    <td><span class="badge bg-secondary">{{ count($attribute->values ?? []) }}</span></td>


                    <td>
                        <input type="number" name="order_level" value="{{ $attribute->order_level }}" data-id="{{ $attribute->id }}" data-original="{{ $attribute->order_level }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                    </td>


                    <td>
                        <form class="status-form" data-id="{{ $attribute->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $attribute->id }}">
                            <input type="checkbox" {{ $attribute->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>


                    <td>
                        <div class="btn-group btn-group-sm">
                            @if(auth('admin')->user()->hasPermission('product-attribute', 'update'))
                                <a href="{{ route('admin.product-attribute.edit', $attribute->id) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            @endif
                            @if(auth('admin')->user()->hasPermission('product-attribute', 'delete'))
                                <button type="button" class="btn btn-outline-danger" title="Delete" onclick="confirmDelete(event, 'deleteForm{{ $attribute->id }}')"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                        <form action="{{ route('admin.product-attribute.destroy', $attribute->id) }}" method="POST" id="deleteForm{{ $attribute->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>No attributes found
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    @if($attributes->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $attributes->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>