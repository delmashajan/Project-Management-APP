<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with('attributeValues.attribute');

        // Apply filters for regular fields (name, status, etc.)
        if ($request->has('filters')) {
            foreach ($request->filters as $key => $value) {
                if (in_array($key, ['name', 'status','created_at','updated_at'])) {
                    // Support basic operators (=, >, <, LIKE)
                    if (is_array($value) && isset($value['operator'], $value['value'])) {
                        $operator = $value['operator'];
                        $query->where($key, $operator, $value['value']);
                    } else {
                        $query->where($key, $value);
                    }
                } else {
                    // Handle EAV attributes filtering
                    $query->whereHas('attributeValues', function ($q) use ($key, $value) {
                        $q->whereHas('attribute', function ($subQ) use ($key) {
                            $subQ->where('name', $key);
                        });

                        // Support basic operators (=, >, <, LIKE)
                        if (is_array($value) && isset($value['operator'], $value['value'])) {
                            $operator = $value['operator'];
                            $q->where('value', $operator, $value['value']);
                        } else {
                            $q->where('value', $value);
                        }
                    });
                }
            }
        }

        $projects = $query->get();
        return response()->json($projects);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|string',
            'attributes' => 'sometimes|array',
            'attributes.*.attribute_id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required|string',
        ]);

        // Create Project
        $project = Project::create($request->only('name', 'status'));

        // Ensure attributes exist in the request
        $attributes = $request->input('attributes', []);

        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                AttributeValue::create([
                    'attribute_id' => $attribute['attribute_id'],
                    'entity_id' => $project->id,
                    'value' => $attribute['value'],
                ]);
            }
        }

        // Return project with attributes
        return response()->json($project->load('attributeValues'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::with('attributeValues')->find($id);
        if (!empty($project)) {
            return response()->json($project);
        } else {
            return response()->json(['message' => 'Project not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|string',
            'attributes' => 'sometimes|array',
            'attributes.*.attribute_id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required|string',
        ]);

        // Find the project and update its details
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }
        $project->update($request->only('name', 'status'));

        // Ensure attributes exist in the request
        $attributes = $request->input('attributes', []);

        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                AttributeValue::updateOrCreate(
                    [
                        'attribute_id' => $attribute['attribute_id'],
                        'entity_id' => $project->id,
                    ],
                    [
                        'value' => $attribute['value'],
                    ]
                );
            }
        }

        // Return project with attributes
        return response()->json($project->load('attributeValues'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
