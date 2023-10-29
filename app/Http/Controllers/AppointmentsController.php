<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

//add the users and implement the auth and the foreign keys
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
        try {
            $validatedData = $request->validate([
                'dateTime'  => 'required|date',
                'status' => 'required|string|in:' . implode(',', StatusEnum::getStatuses()),
                'notes'     => 'required|string'
                // userid
                // serviceid
            ]);

            $appointment = Appointment::create($validatedData);
            return response()->json($appointment, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $existingAppointment = Appointment::find($id);

        if ($existingAppointment) {
            return response()->json($existingAppointment);
        }

        return response()->json("Appointment not found", 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existingAppointment = Appointment::find($id);

        if (!$existingAppointment) {
            return response()->json("Appointment not found", 404);
        }

        try {
            $validatedData = $request->validate([
                'dateTime'  => 'required|date',
                'status' => 'required|string|in:' . implode(',', StatusEnum::getStatuses()),
                'notes'     => 'required|string'
                // userid
                // serviceid
            ]);

            $existingAppointment->update($validatedData);
            return response()->json($existingAppointment, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
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
