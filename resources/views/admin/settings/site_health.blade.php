@extends('layouts.admin.main')

@section('title', 'Site Health')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Site Health" subTitle="Status Overview" :breadcrumbItems="['Dashboard', 'Site Health']" />
    
    <div class="card mb-3">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-activity me-2"></i>Site Health Dashboard</h6>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row g-3">
                <!-- Server Information -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm border h-100">
                        <div class="card-header bg-white fw-bold">Server Information</div>
                        <div class="card-body p-0">
                            <table class="table table-striped align-middle mb-0">
                                <tbody>
                                    @foreach ($serverInfo as $key => $value)
                                    <tr>
                                        <td class="fw-semibold text-muted" width="50%">{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Directories and Health Status -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm border h-100 mb-3">
                        <div class="card-header bg-white fw-bold">Directory Sizes</div>
                        <div class="card-body p-0">
                            <table class="table table-striped align-middle mb-0">
                                <tbody>
                                    @foreach ($directories as $dir => $size)
                                    <tr>
                                        <td class="fw-semibold text-muted" width="50%">{{ ucfirst(str_replace('_', ' ', $dir)) }}</td>
                                        <td>{{ $size }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow-sm border">
                        <div class="card-header bg-white fw-bold">Health Status</div>
                        <div class="card-body p-0">
                            <table class="table table-striped align-middle mb-0">
                                <tbody>
                                    @foreach ($siteHealthStatus as $key => $value)
                                    <tr>
                                        <td class="fw-semibold text-muted" width="50%">{{ $key }}</td>
                                        <td>
                                            @if(str_contains($value, 'Yes') || str_contains($value, 'Connected') || str_contains($value, 'All installed'))
                                                <span class="badge bg-success">{{ $value }}</span>
                                            @elseif(str_contains($value, 'No') || str_contains($value, 'Failed') || str_contains($value, 'Missing'))
                                                <span class="badge bg-danger">{{ $value }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $value }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Disk Space Chart -->
                <div class="col-12 mt-3">
                    <div class="card shadow-sm border">
                        <div class="card-header bg-white fw-bold">Disk Space Usage (Last 7 Days)</div>
                        <div class="card-body">
                            <canvas id="diskSpaceChart" height="100"></canvas>
                        </div>
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
    const ctx = document.getElementById('diskSpaceChart');
    
    @if(!empty($diskChartData['data']))
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($diskChartData['labels']) !!}, 
                datasets: [{
                    label: 'Disk Usage',
                    data: {!! json_encode($diskChartData['data']) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let val = context.raw;
                                return (val / 1024 / 1024 / 1024).toFixed(2) + ' GB';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return (value / 1024 / 1024 / 1024).toFixed(1) + ' GB';
                            }
                        }
                    }
                }
            }
        });
    @else
        ctx.parentNode.innerHTML = '<div class="alert alert-info mb-0"><i class="bi bi-info-circle me-2"></i>Run <code>php artisan health:check</code> in terminal to generate chart data.</div>';
    @endif
</script>
@endpush