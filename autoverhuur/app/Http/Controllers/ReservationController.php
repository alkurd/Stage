<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Car;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('car')->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Optie B: Via querystring / Request
    public function create(Car $car)
{
    // Haal alle actieve reserveringen op van de auto
    $reservations = $car->reservations()
        ->select('start_date', 'end_date')
        ->get();

    // Zet de datums om naar het formaat dat Flatpickr verwacht
    $disabledDates = [];
    foreach ($reservations as $reservation) {
        $disabledDates[] = [
            'from' => $reservation->start_date,
            'to'   => $reservation->end_date,
        ];
    }

    return view('reservations.create', compact('car', 'disabledDates'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id'        => 'required|exists:cars,id',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'birth_date'    => 'required|date|before:' . now()->subYears(18)->format('Y-m-d'),
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after:start_date',
        ]);

        $overlap = Reservation::where('car_id', $validated['car_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function ($query) use ($validated) {
                          $query->where('start_date', '<=', $validated['start_date'])
                                ->where('end_date', '>=', $validated['end_date']);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()
            ->withErrors(['start_date' => 'Deze auto is op de geselecteerde datums al gereserveerd.']);
        }   
        $reservation = Reservation::create($validated);
        $reservation->car->update(['beschikbaar' => false]);
        return redirect()->route('reservations.conformation', $reservation)->with('success', 'Reservering succesvol gemaakt!');
    }
    public function conformation(Reservation $reservation, Car $car)
    {
        return view('reservations.conformation', compact('reservation', 'car'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $reservation->load('car');
        return view('admin.reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'car_id'        => 'required|exists:cars,id',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'birth_date'    => 'required|date|before:' . now()->subYears(18)->format('Y-m-d'),
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after:start_date',
        ]);

        $overlap = Reservation::where('car_id', $validated['car_id'])
            ->where('id', '!=', $reservation->id) // Exclude the current reservation from the overlap check
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function ($query) use ($validated) {
                          $query->where('start_date', '<=', $validated['start_date'])
                                ->where('end_date', '>=', $validated['end_date']);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()
            ->withErrors(['start_date' => 'Deze auto is op de geselecteerde datums al gereserveerd.']);
        }   
        $reservation->update($validated);
        return redirect()->route('admin.reservations.index')->with('success', 'Reservering succesvol gewijzigd!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservering succesvol verwijderd!');
    }
}
