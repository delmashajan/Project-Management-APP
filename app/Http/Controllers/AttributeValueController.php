<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributeValues = AttributeValue::get();
        return response()->json(['data' => $attributeValues], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string',
            'entity_id' => 'required|exists:projects,id',
        ]);

        $attributeValue = AttributeValue::create($request->all());
        return response()->json($attributeValue, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attributeValue = AttributeValue::find($id);
        if (empty($attributeValue)) {
            return response()->json(['message' => 'AttributeValue not found'], 404);
        }
        return response()->json(['data' => $attributeValue], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'attribute_id' => 'required|exists:attributes,id',
                'value' => 'required|string',
                'entity_id' => 'required|exists:projects,id',
            ]);

            $attributeValue = AttributeValue::findOrFail($id);

            $attributeValue->update($request->only('attribute_id', 'value', 'entity_id'));
            return response()->json(['message' => 'AttributeValue updated successfully','data' => $attributeValue], 200);
        } catch (ModelNotFoundException $e) {
            // Handle the "not found" exception
            return response()->json([
                'message' => 'Attribute Value not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attributeValue = AttributeValue::find($id);
        if (empty($attributeValue)) {
            return response()->json(['message' => 'AttributeValue not found'], 404);
        }
        $attributeValue->delete();
        return response()->json(['message' => 'AttributeValue deleted successfully'], 200);
    }
}
