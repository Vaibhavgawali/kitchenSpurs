<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;

class UserTasksController extends Controller
{
    public function userTasks($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $tasks = $user->tasks()->withPivot('status')->get()->map(function ($task) {
            $task->pivot->updated_at = now();
            $task->pivot->save();

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'due_date' => $task->due_date,
                'status' => $task->pivot->status,
                'created_at' => $task->pivot->created_at,
                'updated_at' => $task->pivot->updated_at
            ];
        });
        if ($tasks->isEmpty()) {
            return Response(['success' => true, 'message' => 'User do not assigned any tasks'], 200);
        }

        return Response(['success' => true, 'tasks' => $tasks], 200);
    }

    public function loggedUserTasks()
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);

        $tasks = $user->tasks()->withPivot('status')->get()->map(function ($task) {
            $task->pivot->updated_at = now();
            $task->pivot->save();

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'due_date' => $task->due_date,
                'status' => $task->pivot->status,
                'created_at' => $task->pivot->created_at,
                'updated_at' => $task->pivot->updated_at
            ];
        });

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'You have no tasks assigned'], 200);
        }

        return Response(['success' => true, 'tasks' => $tasks], 200);
    }
}
