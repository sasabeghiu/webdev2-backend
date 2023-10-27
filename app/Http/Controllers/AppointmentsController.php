<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::orderBy('dateTime', 'desc')->paginate(5);

        if ($appointments->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dateTime'  => 'required|date',
            'status'    => 'required|string',
            'notes'     => 'required|string'
            // userid
            // serviceid
        ]);

        $appointment = Appointment::create($validatedData);
        return response()->json($appointment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $existingAppointment = Appointment::findOrFail($id);
            return $this->json($existingAppointment);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->json("Appointment not found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existingAppointment = Appointment::find($id);

        if ($existingAppointment) {
            $validatedData = $request->validate([
                'dateTime'  => 'required|date',
                'status'    => 'required|string',
                'notes'     => 'required|string'
                // userid
                // serviceid
            ]);

            $existingAppointment->update($validatedData);
            return response()->json($existingAppointment, 200);
        }
        return response()->json("Appointment not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $existingAppointment = Appointment::find($id);

        if ($existingAppointment) {
            $existingAppointment->delete();
            return response()->json(null, 204);
        }

        return response()->json("Appointment not found", 404);
    }
}
