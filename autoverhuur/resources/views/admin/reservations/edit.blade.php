@extends('layouts.main')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reservering #{{ $reservation->id }} Bewerken</h2>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">Annuleren</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="car_id" value="{{ $reservation->car_id }}">
                <h5 class="mb-3 text-primary">Klantgegevens Aanpassen</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Naam klant</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $reservation->name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">E-mailadres</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $reservation->email) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">Telefoonnummer</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $reservation->phone) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="birth_date" class="form-label">Geboortedatum</label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $reservation->birth_date) }}" required>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Reservering & Datums</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Startdatum</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $reservation->start_date) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Einddatum</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $reservation->end_date) }}" required>
                    </div>
                    <!-- <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>In behandeling</option>
                            <option value="approved" {{ old('status', $reservation->status) == 'approved' ? 'selected' : '' }}>Goedgekeurd</option>
                            <option value="rejected" {{ old('status', $reservation->status) == 'rejected' ? 'selected' : '' }}>Afgewezen</option>
                            <option value="completed" {{ old('status', $reservation->status) == 'completed' ? 'selected' : '' }}>Afgerond</option>
                        </select>
                    </div> -->
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection