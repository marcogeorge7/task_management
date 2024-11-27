<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    private $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in-progress,completed',
        ]);

        return response()->json($this->projectService->createProject($data), 201);
    }

    public function index(Request $request) {
        $filters = $request->only(['status', 'date_range']);
        return response()->json($this->projectService->listProjects($filters));
    }

    public function show(int $id) {
        return response()->json($this->projectService->getProjectDetails($id));
    }
}
