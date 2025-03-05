<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::get();
        return response()->json(['data' => $attributes], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:text,date,number,select',
        ]);

        $attribute = Attribute::create($request->all());
        return response()->json($attribute, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attribute = Attribute::find($id);

        // If timesheet not found, return error response
        if (!$attribute) {
            return response()->json(['message' => 'Attribute not found'], 404);
        }

        // Return the timesheet
        return response()->json(['data' => $attribute], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'sometimes|string',
                'type' => 'sometimes|in:text,date,number,select',
            ]);

            // Find the attribute or fail
            $attribute = Attribute::findOrFail($id);

            // Update the attribute
            $attribute->update($request->only('name', 'type'));

            // Return a success response
            return response()->json($attribute);

        } catch (ModelNotFoundException $e) {
            // Handle the "not found" exception
            return response()->json([
                'message' => 'Attribute not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json([
                'message'=> 'Attribute not found',
                ],404);
        }
        $attribute->delete();
        return response()->json(['message'=> 'Attribute deleted successfully'],200);
    }
}
