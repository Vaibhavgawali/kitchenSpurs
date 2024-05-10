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

        $tasks = $user->tasks()->withPivot('status')->get();
        if ($tasks->isEmpty()) {
            return Response(['success' => true, 'message' => 'User do not assigned any tasks'], 200);
        }

        return Response(['success' => true, 'tasks' => $tasks], 200);
    }

    public function loggedUserTasks()
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);

        $tasks = $user->tasks()->withPivot('status')->get();

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'You have no tasks assigned'], 200);
        }

        return Response(['success' => true, 'tasks' => $tasks], 200);
    }
}
