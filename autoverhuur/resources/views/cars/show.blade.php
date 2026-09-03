@extends('layouts.main')
@section('titel',$car->merk . ' ' . $car->model)
@section('content')

<!-- @if($car->primary_image)
    <img src="{{ asset('storage/' . $car->primary_image) }}" alt="Auto foto" class="img-fluid mb-3">
@endif -->
<div class="row ">
    @foreach($car->images as $image)
    <div class="col-6 col-md-3 mb-3">
    <!-- <div class="mb-3"> -->
        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Auto foto" class="img-fluid mb-2">
    </div>
@endforeach
</div>

<h1 class="text-capitalize"><strong>{{ $car->merk }}</strong> {{ $car->model }}</h1>
<p>Bouwjaar: {{ $car->bouwjaar }}</p>
<p>Prijs/Dag: €{{ number_format($car->price_per_day, 2, ',', '.') }}</p>
<p>Omschrijving: {{ $car->omschrijving }}</p>
<p>Beschikbaar: {{ $car->beschikbaar ? 'Ja' : 'Nee' }}</p>
@if($car->beschikbaar)
    <a href="{{ route('reservations.create', $car) }}" class="btn btn-success">Reserveer Nu</a>
@else
    @if($car->reservations->isNotEmpty())
        @php
            $latestReservation = $car->reservations->sortByDesc('end_date')->first();
            $availableFrom = \Carbon\Carbon::parse($latestReservation->end_date)->addDay()->format('d-m-Y');
        @endphp
        <p class="text-danger">Kan pas verhuurd worden vanaf {{ $availableFrom }}.</p>
    @endif
    <a href="{{ route('reservations.create', $car) }}" class="btn btn-success">Toch reserveren</a>
@endif

<a href="{{ route('cars.index') }}" class="btn btn-secondary">Terug naar alle auto's</a>


@endsection
