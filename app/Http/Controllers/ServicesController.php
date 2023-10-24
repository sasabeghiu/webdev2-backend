<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('price', 'desc')->paginate(10);

        if ($services->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',
            'image'         => 'required|string',
            'category'      => 'required|string',
            'price'         => 'required|string',
            'duration'      => 'required|string'
        ]);

        $service = Service::create($validatedData);
        return response()->json($service, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $existingService = Service::find($id);

        if ($existingService) {
            return response()->json($existingService);
        }

        return response()->json("Service not found", 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existingService = Service::find($id);

        if ($existingService) {
            $validatedData = $request->validate([
                'name'          => 'required|string',
                'description'   => 'required|string',
                'image'         => 'required|string',
                'category'      => 'required|string',
                'price'         => 'required|string',
                'duration'      => 'required|string'
            ]);
            $existingService->update($validatedData);
            return response()->json($existingService, 200);
        }

        return response()->json("Service not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $existingService = Service::find($id);

        if ($existingService) {
            $existingService->delete();
            return response()->json(null, 204);
        }

        return response()->json("Service not found", 404);
    }
}
