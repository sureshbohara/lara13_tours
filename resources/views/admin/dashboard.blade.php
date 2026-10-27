@extends('layouts.admin.main')

@section('title', 'Dashboard')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Dashboard" subTitle="Admin Dashboard" :breadcrumbItems="['Home', 'Main']" />

   
    <div class="card radius-10 mb-3">
        <div class="card-header bg-transparent">
            <div class="row g-3 align-items-center">
                <div class="col">
                    <h5 class="mb-0">Analytics Dashboard</h5>
                </div>
                <div class="col">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <div class="dropdown">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel text-secondary"></i> {{ request('filter', 'Today') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'Today']) }}">Today</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'Yesterday']) }}">Yesterday</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'This Week']) }}">This Week</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'Last 7 Days']) }}">Last 7 Days</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'This Month']) }}">This Month</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'All']) }}">All Time</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3">
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Services</p>
                            <h4 class="my-1">{{ $stats['services_count'] }}</h4>
                            <p class="mb-0 font-13 text-success"><i class="bi bi-check-circle"></i> {{ $stats['services_active'] }} Active</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-primary text-white ms-auto"><i class="bi bi-hdd-network"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Packages</p>
                            <h4 class="my-1">{{ $stats['packages_count'] }}</h4>
                            <p class="mb-0 font-13 text-info"><i class="bi bi-diagram-3"></i> {{ $stats['packages_active'] }} Active</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-suitcase-lg"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Reviews</p>
                            <h4 class="my-1">{{ $stats['reviews_count'] }}</h4>
                            <p class="mb-0 font-13 text-warning"><i class="bi bi-star"></i> Customer Feedback</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-warning text-white ms-auto"><i class="bi bi-chat-square-text"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Disk Usage</p>
                            <h4 class="my-1">{{ $stats['server']['used_percent'] }}%</h4>
                            <p class="mb-0 font-13 text-danger"><i class="bi bi-hdd-rack"></i> {{ $stats['server']['used_gb'] }} / {{ $stats['server']['total_gb'] }} GB</p>
                        </div>
                        <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-server"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card radius-10 mb-3">
        <div class="card-body">
            <h5 class="card-title mb-3">Traffic Overview</h5>
            <div style="height: 300px;">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>
    </div>

   
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3">
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Sessions</p>
                            <h4 class="my-1">{{ $analytics['totalSessions'] }}</h4>
                        </div>
                        <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="bi bi-house-door"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Visitors</p>
                            <h4 class="my-1">{{ $analytics['visitors'] }}</h4>
                        </div>
                        <div class="widget-icon-large bg-gradient-success text-white ms-auto"><i class="bi bi-person-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Page Views</p>
                            <h4 class="my-1">{{ $analytics['pageviews'] }}</h4>
                        </div>
                        <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-file-earmark-text"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-3">
            <div class="card radius-10 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Bounce Rate</p>
                            <h4 class="my-1">{{ $analytics['bounceRate'] }}%</h4>
                        </div>
                        <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-pie-chart-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 col-lg-6 mb-3">
            <div class="card radius-10 h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Most Visited Pages</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Page URL</th>
                                    <th class="text-end">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['mostVisitedPages'] as $page)
                                    <tr>
                                        <td class="text-truncate" style="max-width: 250px;" title="{{ $page['page_url'] }}">{{ $page['page_url'] }}</td>
                                        <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $page['pageviews'] }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center py-3 text-muted">No data available</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-3">
            <div class="card radius-10 h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Top Browsers</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Browser</th>
                                    <th class="text-end">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['topBrowsers'] as $browser)
                                    <tr>
                                        <td>{{ $browser['browser'] }}</td>
                                        <td class="text-end"><span class="badge bg-info rounded-pill">{{ $browser['count'] }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center py-3 text-muted">No data available</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('viewsChart').getContext('2d');
        
        const chartData = {
            labels: @json($analytics['chartLabels']),
            datasets: [{
                label: 'Pageviews',
                data: @json($analytics['hourlyViews']),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                }
            }
        });
    });
</script>
@endpush