<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarImage;
use App\Models\Car;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CarImageController extends Controller
{
    public function index(){
        $image = CarImage::All();
    }

    public function store(Request $request, Car $car){
        $validate = $request->validate([
            "primary_images"    =>"nullable|array",
            "primary_images.*"  =>"image|mimes:jpeg,png,jpg,webp|max:10240",
        ]);
        if($request->hasFile("primary_images")){
            foreach($request->file("primary_images") as $index => $image){
                $path = $image->store('cars', 'public');

                $car->images()->create([
                    'image_path' => $path,
                ]);

                if ($index === 0) {
                    $car->update(['primary_image' => $path]);
                }
            }
        }
    }
    // $car->create($validate)

    public function destroy(CarImage $image){
        Storage::disk("public")->delete($image->image_path);
        $image->delete();
        return back()->with('sucsess','');
    }
}
