@extends('layouts.admin.main')

@section('title', 'Package Itinerary')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Packages" subTitle="Itinerary" :breadcrumbItems="['Dashboard', 'Packages', 'Itinerary']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-map me-2"></i> Itinerary For: {{ $data->name }}
            </h6>
            <a href="{{ route('admin.package.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.trip.itinerary', $data->id) }}" method="POST">
                @csrf
                
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h5 class="card-title mb-4 border-bottom pb-2">Daily Itinerary Steps</h5>
                        
                     
                        @php
                            $itinerarySteps = [];
                            
                            if (old('title')) {
                
                                $titles = old('title', []);
                                foreach ($titles as $i => $title) {
                                    $itinerarySteps[] = [
                                        'name' => $title,
                                        'content' => old('content')[$i] ?? '',
                                        'max_elevation' => old('max_elevation')[$i] ?? '',
                                        'duration' => old('duration')[$i] ?? '',
                                        'distance' => old('distance')[$i] ?? '',
                                        'meals' => old('meals')[$i] ?? '',
                                        'accommodation' => old('accommodation')[$i] ?? '',
                                    ];
                                }
                            } else {
        
                                $rawData = $data->itinerary_data ?? [];
                                
                                if (is_array($rawData) && isset($rawData[0])) {
            
                                    $itinerarySteps = $rawData;
                                } elseif (is_array($rawData) && isset($rawData['title'])) {
        
                                    $count = count($rawData['title']);
                                    for ($i = 0; $i < $count; $i++) {
                                        $itinerarySteps[] = [
                                            'name' => $rawData['title'][$i] ?? '',
                                            'content' => $rawData['content'][$i] ?? '',
                                            'max_elevation' => $rawData['max_elevation'][$i] ?? '',
                                            'duration' => $rawData['duration'][$i] ?? '',
                                            'distance' => $rawData['distance'][$i] ?? '',
                                            'meals' => $rawData['meals'][$i] ?? '',
                                            'accommodation' => $rawData['accommodation'][$i] ?? '',
                                        ];
                                    }
                                }
                            }
                        @endphp

                        <div class="itineraryDisplay">
                            @foreach ($itinerarySteps as $index => $step)
                                <div class="row mb-4 p-3 border rounded bg-light itinerary-step">
                                    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="day-title mb-0 text-primary fw-bold">Day {{ $index + 1 }}</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger removeItineraryStep">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="title_{{ $index }}">Step Title</label>
                                        <input type="text" class="form-control @error('title.' . $index) is-invalid @enderror" id="title_{{ $index }}" name="title[]" value="{{ $step['name'] ?? '' }}" placeholder="e.g., Arrival in Kathmandu and Hotel Transfer" required>
                                        @error('title.' . $index) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="content_{{ $index }}">Description</label>
                                        <textarea class="form-control @error('content.' . $index) is-invalid @enderror" id="content_{{ $index }}" name="content[]" rows="3" placeholder="Describe the activities for this day..." required>{{ $step['content'] ?? '' }}</textarea>
                                        @error('content.' . $index) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="max_elevation_{{ $index }}">Max Elevation</label>
                                        <input type="text" class="form-control form-control-sm" id="max_elevation_{{ $index }}" name="max_elevation[]" value="{{ $step['max_elevation'] ?? '' }}" placeholder="e.g., 5,545m">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="duration_{{ $index }}">Duration</label>
                                        <input type="text" class="form-control form-control-sm" id="duration_{{ $index }}" name="duration[]" value="{{ $step['duration'] ?? '' }}" placeholder="e.g., 6 Hours">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="distance_{{ $index }}">Distance</label>
                                        <input type="text" class="form-control form-control-sm" id="distance_{{ $index }}" name="distance[]" value="{{ $step['distance'] ?? '' }}" placeholder="e.g., 12 km">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="meals_{{ $index }}">Meals</label>
                                        <input type="text" class="form-control form-control-sm" id="meals_{{ $index }}" name="meals[]" value="{{ $step['meals'] ?? '' }}" placeholder="e.g., B/L/D">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="accommodation_{{ $index }}">Accommodation</label>
                                        <input type="text" class="form-control form-control-sm" id="accommodation_{{ $index }}" name="accommodation[]" value="{{ $step['accommodation'] ?? '' }}" placeholder="e.g., 3-Star Hotel in Kathmandu">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center border-top pt-3">
                            <button type="button" class="btn btn-outline-primary addItineraryStep">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Day
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Update Itinerary
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        let stepCount = {{ count($itinerarySteps) }};
        
        const template = (i) => `
        <div class="row mb-4 p-3 border rounded bg-light itinerary-step">
            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                <h6 class="day-title mb-0 text-primary fw-bold">Day ${i + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger removeItineraryStep">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label">Step Title</label>
                <input type="text" class="form-control" name="title[]" placeholder="e.g., Arrival in Kathmandu and Hotel Transfer" required>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="content[]" rows="3" placeholder="Describe the activities for this day..." required></textarea>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Max Elevation</label>
                <input type="text" class="form-control form-control-sm" name="max_elevation[]" placeholder="e.g., 5,545m">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Duration</label>
                <input type="text" class="form-control form-control-sm" name="duration[]" placeholder="e.g., 6 Hours">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Distance</label>
                <input type="text" class="form-control form-control-sm" name="distance[]" placeholder="e.g., 12 km">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Meals</label>
                <input type="text" class="form-control form-control-sm" name="meals[]" placeholder="e.g., B/L/D">
            </div>

            <div class="col-md-12">
                <label class="form-label">Accommodation</label>
                <input type="text" class="form-control form-control-sm" name="accommodation[]" placeholder="e.g., 3-Star Hotel in Kathmandu">
            </div>
        </div>`;


        $('.addItineraryStep').click(() => { 
            $('.itineraryDisplay').append(template(stepCount++)); 
        });

        $(document).on('click', '.removeItineraryStep', function () {
            $(this).closest('.itinerary-step').remove();
            $('.itinerary-step').each((i, el) => {
                $(el).find('.day-title').text(`Day ${i + 1}`);
            });
            stepCount = $('.itinerary-step').length;
        });
    });
</script>
@endpush