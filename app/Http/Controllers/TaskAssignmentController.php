<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Task;

class TaskAssignmentController extends Controller
{
    public function assignUser(Request $request, $taskId)
    {

        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'status' => 'nullable|in:pending,in progress,completed',
        ], [
            'user_ids.*.exists' => 'One or more selected users are invalid.',
        ]);

        if ($validator->fails()) {
            return Response(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $task = Task::findOrFail($taskId);

        $task = Task::find($taskId);
        if (!$task) {
            return Response(['success' => false, 'message' => 'Task not found'], 404);
        }

        $users = User::find($request->user_ids);

        $attachedUsers = 0;
        foreach ($users as $user) {
            if (!$task->users()->where('user_id', $user->id)->exists()) {
                $task->users()->attach($user->id, ['status' => $request->status ?? 'pending']);
                $attachedUsers++;
            }
        }

        if ($attachedUsers == 0) {
            return Response(['success' => true, 'message' => 'Users are already assigned to the task']);
        }

        return response()->json(['success' => true, 'message' => 'Users assigned to  the task']);
    }

    public function unassignUser(Request $request, $taskId)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Response(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $task = Task::find($taskId);
        if (!$task) {
            return Response(['success' => false, 'message' => 'Task not found'], 404);
        }

        $userId = $request->user_id;
        if ($task->users()->where('user_id', $userId)->exists()) {
            $detached = $task->users()->detach($userId);

            if ($detached > 0) {
                return response()->json(['success' => true, 'message' => 'User unassigned from the task']);
            }
            return Response(['success' => true, 'message' => 'Failed to unassign user from the task'], 200);
        }
        return Response(['success' => true, 'message' => 'User is not assigned to the task'], 404);
    }

    public function updateStatus(Request $request, $taskId)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,in progress,completed',
        ]);

        if ($validator->fails()) {
            return Response(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $task = Task::find($taskId);
        if (!$task) {
            return Response(['success' => false, 'message' => 'Task not found'], 404);
        }

        $userId = $request->user_id;
        if (!$task->users()->where('user_id', $userId)->exists()) {
            return Response(['success' => false, 'message' => 'Task is not assigned to this user'], 403);
        }

        $updatedStatus = $task->users()->updateExistingPivot($userId, ['status' => $request->status, 'updated_at' => now()]);
        if (!$updatedStatus) {
            return Response(['success' => true, 'message' => 'Failed to unassign user from the task'], 500);
        }

        return Response(['success' => true, 'message' => 'Task status updated'], 200);
    }
}
