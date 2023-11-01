<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with('service')->orderBy('dateTime', 'desc')->paginate(5);

        if ($appointments->isEmpty()) {
            return response()->json([]);
        }

        foreach ($appointments as $appointment) {
            //concatinate service id and name to display in the front end field data
            $serviceIdandName = $appointment->service->id . ' - ' . $appointment->service->name;
            $appointment->serviceId = $serviceIdandName;

            //remove service object from the response
            unset($appointment->service);
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
                'notes'     => 'required|string',
                'serviceId' => 'required|exists:services,id'
                // userid
            ]);

            $appointment = Appointment::create($validatedData);
            $appointment->serviceId = $validatedData['serviceId'];
            $appointment->save();

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
        $existingAppointment = Appointment::with('service')->find($id);

        if ($existingAppointment) {
            //concatinate service id and name to display in the front end field data
            $serviceIdandName = $existingAppointment->service->id . ' - ' . $existingAppointment->service->name;
            $existingAppointment->serviceId = $serviceIdandName;

            //remove service object from the response
            unset($existingAppointment->service);

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
                'notes'     => 'required|string',
                'serviceId' => 'required|exists:services,id'
                // userid
            ]);

            $existingAppointment->update($validatedData);
            $existingAppointment->serviceId = $validatedData['serviceId'];
            $existingAppointment->save();

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
