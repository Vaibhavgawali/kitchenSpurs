<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        if (Auth::check()) {
            $tasks = Task::query();

            // Filter by status
            if ($request->has('status')) {
                $tasks->where('status', $request->status);
            }

            // Filter by date
            if ($request->has('date')) {
                $tasks->whereDate('due_date', $request->date);
            }

            // Filter by assigned user
            // if ($request->has('assigned_user')) {
            //     $tasks->whereHas('users', function ($query) use ($request) {
            //         $query->where('id', $request->assigned_user);
            //     });
            // }

            $tasks = $tasks->get();

            return Response(['success' => true, 'tasks' => $tasks], 200);
        }

        return Response(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'nullable|in:pending,in progress,completed',
        ]);

        if ($validator->fails()) {
            return Response(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $task = Task::where('title', $request->title)->first();

        if ($task) {
            return Response(['success' => false, 'message' => 'Task with this title already exists'], 409);
        }

        $new_task = Task::Create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        if (!$new_task) {
            return Response(['success' => false, 'message' => "Failed to create task"], 500);
        }

        return Response(['success' => true, 'task' => $new_task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in progress,completed',
        ]);

        if ($validator->fails()) {
            return Response(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $task = Task::where('id', $id)->first();

        if ($task) {
            $isUpdated = $task->update($request->all());

            if ($isUpdated) {
                $task->touch();
                return Response(['success' => true, 'message' => "Task updated successfully"], 200);
            }
            return Response(['success' => false, 'message' => "Failed to update task"], 500);
        }
        return Response(['success' => false, 'message' => "Task not found"], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if ($task) {
            $isDeleted = $task->delete();
            if ($isDeleted) {
                return Response(['success' => true, 'message' => "Task deleted successfully"], 200);
            }
            return Response(['success' => false, 'message' => "Failed to delete task"], 500);
        }
        return Response(['success' => false, 'message' => "Task not found"], 404);
    }
}
