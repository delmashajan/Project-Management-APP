<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all timesheets
        $timesheets = Timesheet::with(['user', 'project'])->get();
        return response()->json(['data' => $timesheets], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the timesheet
        $timesheet = Timesheet::create([
            'task_name' => $request->task_name,
            'date' => $request->date,
            'hours' => $request->hours,
            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
        ]);

        // Return success response
        return response()->json(['data' => $timesheet, 'message' => 'Timesheet created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the timesheet by ID
        $timesheet = Timesheet::with(['user', 'project'])->find($id);

        // If timesheet not found, return error response
        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        // Return the timesheet
        return response()->json(['data' => $timesheet], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the timesheet by ID
        $timesheet = Timesheet::find($id);

        // If timesheet not found, return error response
        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'task_name' => 'sometimes|string|max:255',
            'date' => 'sometimes|date',
            'hours' => 'sometimes|numeric|min:0',
            'user_id' => 'sometimes|exists:users,id',
            'project_id' => 'sometimes|exists:projects,id',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the timesheet
        $timesheet->update([
            'task_name' => $request->task_name ?? $timesheet->task_name,
            'date' => $request->date ?? $timesheet->date,
            'hours' => $request->hours ?? $timesheet->hours,
            'user_id' => $request->user_id ?? $timesheet->user_id,
            'project_id' => $request->project_id ?? $timesheet->project_id,
        ]);

        // Return success response
        return response()->json(['data' => $timesheet, 'message' => 'Timesheet updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the timesheet by ID
        $timesheet = Timesheet::find($id);

        // If timesheet not found, return error response
        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        // Delete the timesheet
        $timesheet->delete();

        // Return success response
        return response()->json(['message' => 'Timesheet deleted successfully'], 200);
    }
}