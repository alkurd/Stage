<div class="row mt-3">
    @foreach($car->images as $image)
    <div class="col-6 col-md-3 mb-3">
        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Auto foto" class="img-fluid img-thumbnail rounded">
        <div class="form-check text-center">
            <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}">
            <label class="text-center text-danger" for="delete_image_{{ $image->id }}">Verwijderen</label>
        </div>
    </div>
    @endforeach
    <label>Afbeelding</label>
    <input type="file"  name="primary_images[]" class=" form-control-file" multiple="multiple"/>
</div>
