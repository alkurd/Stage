<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars =Car::all();
        return view("admin.cars.index", compact("cars"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.cars.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "merk"              =>"required|string|max:255",
            "model"             =>"required|string|max:255",
            "bouwjaar"          =>"required|integer|min:1970|max:".(date('Y') +1),
            "price_per_day"     =>"required|numeric|min:0",
            "omschrijving"      =>"nullable|string",
            "primary_images"    =>"nullable|array",
            "primary_images.*"  =>"image|mimes:jpeg,png,jpg,webp|max:10240",
        ]);
        
        $car = Car::create($validated);

        if ($request->hasFile("primary_images")){
            foreach($request->file("primary_images") as $index => $image){
                $path = $image->store("cars", "public");
                
                // 1. Opslaan in car_images tabel
                $car->images()->create([
                    "image_path" => $path
                ]);

                // 2. Als dit de eerste foto is, stel deze in op het Car model zelf
                if ($index === 0) {
                    $car->update([
                        'primary_image' => $path
                    ]);
                }
            }
        }

        return redirect()->route("admin.cars.index")->with("success", "De auto is succesvol toegevoegd.");

    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $car->load('images');
        return view("admin.cars.edit", compact("car"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            "merk"              => "required|string|max:255",
            "model"             => "required|string|max:255",
            "bouwjaar"          => "required|integer|min:1970|max:" . (date('Y') + 1),
            "price_per_day"     => "required|numeric|min:0",
            "omschrijving"      => "nullable|string",
            "beschikbaar"       => "nullable|boolean",
            "primary_images"    => "nullable|array",
            "primary_images.*"  => "image|mimes:jpeg,png,jpg,webp|max:10240",
        ]);

        // Converteer de beschikbaar-waarde naar een boolean
        $validated["beschikbaar"] = $request->boolean("beschikbaar");

        $car->update($validated);
        // 1. Verwijder geselecteerde afbeeldingen
        if ($request->has("delete_images")) {
            foreach ($request->input("delete_images") as $image_id) {
                $image = CarImage::find($image_id);
                if ($image) {

                if ($car->primary_image === $image->image_path) {
                        $car->update(['primary_image' => null]);
                    }
                    
                    Storage::disk("public")->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // 3. Nieuwe foto's uploaden
        if ($request->hasFile('primary_images')) {
            foreach ($request->file('primary_images') as $index => $image) {
                $newPath = $image->store("cars", "public");

                $car->images()->create([
                    'image_path' => $newPath,
                ]);
            }
        }

        // 4. Als er geen primaire afbeelding is, stel de eerste afbeelding in als primaire afbeelding
        if (!$car->primary_image) {
            $car->update(['primary_image' => 
            $car->images()->first()?->image_path]);
        }

        return redirect()
            ->route("admin.cars.index")
            ->with("success", "De auto is succesvol bijgewerkt.");     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car, CarImage $image)
    {
        // verwijder alle afbeeldingen van de auto
        foreach ($car->images as $image) {
            Storage::disk("public")->delete($image->image_path);
            $image->delete();
        }
        // verwijder de auto zelf
        $car->delete();
        return redirect()->route("admin.cars.index", $car)->with("success", "De auto is succesvol verwijdert.");
    
    }
}
