<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">

     
        <div class="col-md-3">
            <select name="parent_id" class="form-select form-select-sm">
                <option value="">All Parent Categories</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ ($filters['parent_id'] ?? '') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="display_on" class="form-select form-select-sm">
                <option value="">All Display Locations</option>
                <option value="default" {{ ($filters['display_on'] ?? '') == 'default' ? 'selected' : '' }}>Default</option>
                <option value="home" {{ ($filters['display_on'] ?? '') == 'home' ? 'selected' : '' }}>Home</option>
                <option value="page" {{ ($filters['display_on'] ?? '') == 'page' ? 'selected' : '' }}>Page</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                <option value="0" {{ ($filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.category.index') }}" class="btn btn-primary btn-sm text-white"><i class="bi bi-x-circle"></i> Reset Filters</a>
        </div>
    </form>
</div>