@extends('layouts.main')
@section('titel','Auto Toevoegen')
@section('content')

<h1>Autos Toeveogen</h1>
<form method="post" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
    <div class="form-group">
        <label>Merk</label>
        <input type="text" name="merk" class="form-control">
    
        <label>Model</label>
        <input type="text" name="model" class="form-control">
  
        <label>Bouwjaar</label>
        <input type="number" name="bouwjaar"  min="1975" max="{{ date('Y') }}" class="form-control">

        <label>Prijs/Dag</label>
        <input type="number" name="price_per_day" min="89.99" class="form-control">
  
    
        <label>Omschrijving</label>
        <textarea  name="omschrijving" class="form-control"></textarea>
   
        <label>Afbeelding</label>
        <input type="file"  name="primary_images[]" class=" form-control-file" multiple="multiple"/>

    </div>
    <button type="submit">Toevoegen</button>
</form>


@endsection