<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) :JsonResponse
    {
        try {

            $tasks = $request->user()->tasks()->paginate(1);

            return response()->json([
                'success' => true,
                'Message' => 'Tasks Accessed.',
                'data' => $tasks
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) :JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'nullable',
                'deadline' => 'nullable|date',
                'category' => 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error.',
                    'data' => $validator->errors()

                ], 400);
            }
            $input = $request->all();
            $request->user()->tasks()->create($input);

            return response()->json([
                'success' => true,
                'Message' => 'Task created successfully.',
                'data' => []
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show(Request $request, Task $task) {
        try {

            if ($task->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return response()->json([
                'success' => true,
                'Message' => 'Task Accessed.',
                'data' => $task
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        try {

            if ($task->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $task->update($request->all());


            return response()->json([
                'success' => true,
                'Message' => 'Task updated successfully.',
                'data' => $task
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task)
    {
        try {

            if ($task->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $task->delete();

            return response()->json([
                'success' => true,
                'Message' => 'Task Deleted successfully.',
                'data' => []
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function filter(Request $request, $filter) {

        try {
            $query = $request->user()->tasks();

            if ($filter === 'completed') $query->where('status', $filter);
            elseif ($filter === 'pending') $query->where('status', $filter);
            else $query->where('category', $filter);

            $tasks = $query->paginate(1);

            return response()->json([
                'success' => true,
                'Message' => 'Tasks Accessed.',
                'data' => $tasks
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }



    }
}
