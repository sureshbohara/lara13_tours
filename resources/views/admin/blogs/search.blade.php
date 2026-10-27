<div class="col-12">
    <form id="filterForm" method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3 mb-3">

        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" 
                   placeholder="🔍 Search by title, excerpt..." 
                   value="{{ $filters['search'] ?? '' }}">
        </div>

        <div class="col-md-3">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                <option value="0" {{ ($filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary btn-sm text-white" title="Reset Filters">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        </div>
    </form>
</div>