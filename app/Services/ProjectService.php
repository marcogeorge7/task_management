<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function createProject(array $data) {
        return Project::create($data);
    }

    public function listProjects(array $filters) {
        $query = Project::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_range'])) {
            $query->whereBetween('created_at', $filters['date_range']);
        }

        return $query->with('tasks')->get();
    }

    public function getProjectDetails(int $id) {
        return Project::with('tasks')->findOrFail($id);
    }
}
