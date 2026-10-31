@extends('layouts.admin.main')

@section('title', 'Booking Details')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Bookings" subTitle="Booking Details" :breadcrumbItems="['Dashboard', 'Bookings', 'Details']"/>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0"><i class="bi bi-receipt me-2"></i> Booking Details #{{ $booking->id }}</h6>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
        <div class="card-body bg-light p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-primary text-uppercase small fw-bold mb-3 border-bottom pb-2">Customer Information</h6>
                            <table class="table table-borderless mb-0">
                                <tr><td width="150"><strong>Name:</strong></td><td>{{ $booking->name }}</td></tr>
                                <tr><td><strong>Email:</strong></td><td>{{ $booking->email }}</td></tr>
                                <tr><td><strong>Phone:</strong></td><td>{{ $booking->phone }}</td></tr>
                                <tr><td><strong>People:</strong></td><td>{{ $booking->number_of_people }} Pax</td></tr>
                                <tr><td><strong>Travel Date:</strong></td><td>{{ $booking->travel_date ? $booking->travel_date->format('d M, Y') : 'Flexible' }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-primary text-uppercase small fw-bold mb-3 border-bottom pb-2">Trip Information</h6>
                            <table class="table table-borderless mb-0">
                                <tr><td width="150"><strong>Package:</strong></td><td>{{ $booking->package->name ?? 'N/A' }}</td></tr>
                                <tr><td><strong>Fixed Departure:</strong></td><td>{{ $booking->fixedDeparture->start_date ?? 'Flexible / N/A' }}</td></tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @php
                                            $badgeClass = match($booking->status) {
                                                'confirmed' => 'success',
                                                'pending' => 'warning',
                                                'cancelled' => 'danger',
                                                'completed' => 'info',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} text-uppercase">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                </tr>
                                <tr><td><strong>Booked On:</strong></td><td>{{ $booking->created_at->format('d M, Y h:i A') }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-primary text-uppercase small fw-bold mb-3 border-bottom pb-2">Customer Message</h6>
                            <div class="p-3 bg-white rounded border">
                                {{ $booking->message ?: 'No additional message provided.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection