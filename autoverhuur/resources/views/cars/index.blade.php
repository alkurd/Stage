@extends('layouts.main')
@section('titel','Alle Auto\'s')
@section('content')
@if($cars->isEmpty())
    <div class="alert alert-info">
        Er zijn momenteel geen auto's beschikbaar.
    </div>
@endif
@foreach($cars as $car)
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                @if($car->primary_image)
                    <img src="{{ asset('storage/' . $car->primary_image) }}" alt="{{ $car->merk }}" class="img-fluid rounded-start">
                @else
                    <span class="badge bg-secondary">Geen foto</span>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title text-capitalize"><strong>{{ $car->merk }}</strong> {{ $car->model }}</h5>
                    <p class="card-text">Bouwjaar: {{ $car->bouwjaar }}</p>
                    <p class="card-text">Prijs/Dag: €{{ number_format($car->price_per_day, 2, ',', '.') }}</p>
                    <p class="card-text">Beschikbaar: {{ $car->beschikbaar ? 'Ja' : 'Nee' }}</p>
                    <a href="{{ route('cars.show', $car) }}" class="btn btn-primary">Bekijk Details</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection