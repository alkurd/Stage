@extends('layouts.main')
@section('titel','Auto Bewerken')
@section('content')

<h1>Auto's bewerken</h1>
<form method="post" action="{{ route('admin.cars.update', $car) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">

        <label>Merk</label>
        <input type="text" name="merk" value="{{ $car->merk }}" class="form-control">
    
        <label>Model</label>
        <input type="text" name="model" value="{{ $car->model }}" class="form-control">
  
        <label>Bouwjaar</label>
        <input type="number" name="bouwjaar"  value="{{ $car->bouwjaar }}" min="1975" max="{{ date('Y') }}" class="form-control">

        <label>Prijs/Dag</label>
        <input type="number" name="price_per_day" value="{{ $car->price_per_day }}" min="0" class="form-control">  
    
        <label>Omschrijving</label>
        <textarea  name="omschrijving" class="form-control">{{ $car->omschrijving }}</textarea>

        <label>Beschikbaar</label>
        <input type="hidden" name="beschikbaar" value="0">
        <input type="checkbox" name="beschikbaar" value="1" {{ old('beschikbaar', $car->beschikbaar) ? 'checked' : '' }}>
   
        @include('admin.cars.partials._image-manager')

    </div>
    <button type="submit" class="btn btn-outline-success btn-sm m-1 ">Bewerken</button>
</form>

@endsection