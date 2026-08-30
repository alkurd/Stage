<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
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
            "primary_image"     =>"nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
        ]);
        if ($request->hasFile("primary_image")){
            $path = $request->file("primary_image")->store("cars", "public");
            $validated["primary_image"] = $path;
        }
        Car::create($validated);

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
        return view("admin.cars.edit", compact("car"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            "merk"              =>"required|string|max:255",
            "model"             =>"required|string|max:255",
            "bouwjaar"          =>"required|integer|min:1970|max:".(date('Y') +1),
            "price_per_day"     =>"required|numeric|min:0",
            "omschrijving"      =>"nullable|string",
            "primary_image"     =>"nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
            "beschikbaar"       => "boolean",
        ]);
        if ($request->hasFile("primary_image")){
            if($car->primary_image && Storage::disk("public")->exists($car->primary_image)){
                Storage::disk("public")->delete($car->primary_image);
            }
            $path = $request->file("primary_image")->store("cars", "public");
            $validated["primary_image"] = $path;
        }

        $car->update($validated);

        return redirect()->route("admin.cars.show", $car)->with("success", "De auto is succesvol bijgewerkt.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        if($car->primary_image && Storage::disk("public")->exists($car->primary_image)){
                Storage::disk("public")->delete($car->primary_image);
            }
        $car->delete();
        return redirect()->route("admin.cars.index", $car)->with("success", "De auto is succesvol verwijdert.");
    
    }
}
