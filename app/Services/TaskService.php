<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskDependency;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function updateTask(int $id, array $updates)
    {
        $task = Task::findOrFail($id);

        DB::transaction(function () use ($task, $updates) {
            foreach ($updates as $field => $value) {
                $task->histories()->create([
                    'field' => $field,
                    'old_value' => $task->{$field},
                    'new_value' => $value,
                ]);
            }
            $task->update($updates);
        });
        $task->assigned_user->notify(new TaskAssignedNotification($task));

        return $task;
    }

    public function addDependency(int $taskId, int $dependencyId)
    {
        if ($this->checkCircularDependency($taskId, $dependencyId)) {
            throw new \Exception('Circular dependency detected.');
        }

        return TaskDependency::create([
            'task_id' => $taskId,
            'dependency_task_id' => $dependencyId,
        ]);
    }

    private function checkCircularDependency(int $taskId, int $dependencyId)
    {
        $dependencies = Task::find($dependencyId)->dependencies()->pluck('dependency_task_id')->toArray();

        return in_array($taskId, $dependencies);
    }
}
