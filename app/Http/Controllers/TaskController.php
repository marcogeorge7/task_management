<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }

    public function store(Request $request) {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in-progress,completed',
            'assigned_user_id' => 'nullable|exists:users,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
        ]);

        return response()->json($this->taskService->createTask($data), 201);
    }
}
