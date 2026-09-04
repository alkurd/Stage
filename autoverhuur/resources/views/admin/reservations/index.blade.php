@extends('layouts.main')

@section('content')
@if($reservations->isEmpty())
    <div class="alert alert-info">
        Er zijn momenteel geen Reservations.
    </div>
@endif
<table class="table table-striped">
    <thead>
        <tr>
            <th>klat</th>
            <!-- <th>Email</th>
            <th>Telefoonnummer</th> -->
            <th>Startdatum</th>
            <th>Einddatum</th>
            <th>Auto</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $reservation)
        <tr>
            <td>
                <strong class="d-block">{{ $reservation->name }}</strong>
                <small class="text-muted d-block">
                    <a href="mailto:{{ $reservation->email }}" class="text-decoration-none">{{ $reservation->email }}</a>
                </small>
                <small class="text-muted d-block">{{ $reservation->phone }}</small>
            </td>
            <!-- <td>{{ $reservation->email }}</td>
            <td>{{ $reservation->phone }}</td> -->
            <td>{{ $reservation->start_date }}</td>
            <td>{{ $reservation->end_date }}</td>
            <td>{{ $reservation->car->merk }} {{ $reservation->car->model }}</td>
            <td>
                <div class="d-flex flex-column gap-1" style="width: 170px;">
            {{-- Bovenste rij: Verwerken & Verwijderen naast elkaar --}}
            <div class="d-flex gap-1">
                <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-sm btn-outline-primary w-50">
                    Verwerken
                </a>

                <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST"  onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                        Verwijderen
                    </button>
                </form>
            </div>

            {{-- Onderste rij: Goedkeuren (even breed als het blok erboven) --}}
            <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="approved">
                <button type="submit" class="btn btn-sm btn-success w-100">
                    Goedkeuren
                </button>
            </form>
        </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection