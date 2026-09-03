
@extends('layouts.main')
@section('titel', 'Reservation: ' . $car->merk . ' ' . $car->model)

@section('content')
<h1>Reserveer een {{ $car->merk }} {{ $car->model }}</h1>
<form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        {{-- Koppel de auto stilzwijgend via car_id --}}
        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <div class="mb-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mailadres</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Telefoonnummer</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" 
                   inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Geboortedatum (18+)</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" 
                   max="{{ date('Y-m-d', strtotime('-18 years')) }}" value="{{ old('birth_date') }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Startdatum</label>
                <input type="text" name="start_date" id="start_date" class="form-control bg-white" 
                       placeholder="Selecteer startdatum" value="{{ old('start_date') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Einddatum</label>
                <input type="text" name="end_date" id="end_date" class="form-control bg-white" 
                       placeholder="Selecteer einddatum" value="{{ old('end_date') }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Reservering Opslaan</button>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">Annuleren</a>
    </form>
</div>

{{-- Flatpickr CSS & JS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // 1. Haal bezette datums op uit de controller
    const disabledDates = @json($disabledDates);

    // 2. Koppel basis-Flatpickr aan startdatum (alleen datums dimmen)
    const startPicker = flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: disabledDates,
        onChange: function(selectedDates, dateStr) {
            endPicker.set("minDate", dateStr);
        }
    });

    // 3. Koppel basis-Flatpickr aan einddatum (alleen datums dimmen)
    const endPicker = flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: disabledDates
    });
</script>
@endsection