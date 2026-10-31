<div class="col-12">
    <form id="filterForm" method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3 mb-3">

        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" 
                   placeholder="🔍 Search by name, email, phone..." 
                   value="{{ $filters['search'] ?? '' }}">
        </div>

        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="confirmed" {{ ($filters['status'] ?? '') == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                <option value="completed" {{ ($filters['status'] ?? '') == 'completed' ? 'selected' : '' }}>🏁 Completed</option>
            </select>
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm text-white" title="Search">
                <i class="bi bi-search"></i> Search
            </button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm text-white" title="Reset Filters">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        </div>
    </form>
</div>