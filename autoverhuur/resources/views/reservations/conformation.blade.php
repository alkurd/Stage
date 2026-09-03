
@extends('layouts.main')
@section('titel', 'Reservation: ' . $car->merk . ' ' . $car->model)


@section('content')
<p>Beste meneer/mevrouw, {{ $reservation->name }},</p>
<p>Bedankt voor uw reservering! Uw reservering voor de {{ $car->merk }} {{ $car->model }} is succesvol ontvangen.</p>
<p>We zullen de bevestiging van uw reservering zo snel mogelijk doorsturen naar {{ $reservation->email }}.</p>
<p>Als u vragen heeft, neem dan gerust contact met ons op.</p>
<a href="{{ route('cars.index') }}" class="btn btn-primary">Terug naar auto's</a>
@endsection