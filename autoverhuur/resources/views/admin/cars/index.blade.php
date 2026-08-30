@extends('layouts.main')
@section('titel','Auto Beheer\'s')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Auto Beheer</h2>
        <a href="{{ route('admin.cars.create') }}" class="btn btn-success">+ Nieuwe Auto Toevoegen</a>
    </div>
<!-- <div class="card shadow-sm"> -->
    <div class="card-body">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Afbeelding</th>
                    <th>Merk & Model</th>
                    <th>Bouwjaar</th>
                    <th>Prijs/Dag</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse( $cars as $car)
                <tr>
                    <td></td>
                    <td><strong>{{ $car->merk }}</strong> {{ $car->model }}</td>
                    <td>{{ $car->bouwjaar }}</td>
                    <td>{{ $car->price_per_day }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-outline-primary btn-sm m-1">Bewerken</a>
                        <form action="{{ route('admin.cars.destroy', $car) }}" method="post" class="d-inline" onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ouline-danger btn-sm" >Verwijderen</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        Er zijn nog geen auto's toegevoegd.
                    </td>
                </tr>
            </tbody>
            @endforelse
        </table>
    </div>
</div>

@endsection