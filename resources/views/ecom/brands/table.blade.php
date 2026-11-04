<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Logo</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                <tr>


                    <td><img src="{{ $brand->logo_url ?? asset('default/noimage.png') }}" class="rounded" width="50" height="50" style="object-fit: cover;"></td>


                    <td>
                        <strong>{{ $brand->name }}</strong><br>
                        <small class="text-muted">{{ $brand->slug }}</small>
                    </td>


                    <td>
                        @if($brand->website)
                            <a href="{{ $brand->website }}" target="_blank" class="text-decoration-none"><i class="bi bi-box-arrow-up-right"></i> Visit</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>


                    <td>
                        <input type="number" name="order_level" value="{{ $brand->order_level }}" data-id="{{ $brand->id }}" data-original="{{ $brand->order_level }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                    </td>


                    <td>
                        <form class="status-form" data-id="{{ $brand->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $brand->id }}">
                            <input type="checkbox" {{ $brand->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>


                    <td>
                        <div class="btn-group btn-group-sm">
                            @if(auth('admin')->user()->hasPermission('brand', 'update'))
                                <a href="{{ route('admin.brand.edit', $brand->id) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            @endif
                            @if(auth('admin')->user()->hasPermission('brand', 'delete'))
                                <button type="button" class="btn btn-outline-danger" title="Delete" onclick="confirmDelete(event, 'deleteForm{{ $brand->id }}')"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                        <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST" id="deleteForm{{ $brand->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>


                </tr>
                @empty
                   <tr>
                     <td colspan="6" class="text-center py-4 text-muted">
                     <i class="bi bi-inbox fs-1 d-block mb-2"></i>No brands found</td>
                  </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($brands->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $brands->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>