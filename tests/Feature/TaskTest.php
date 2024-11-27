<?php


use App\Models\Task;

it('can add a dependency', function () {
    $task1 = Task::factory()->create();
    $task2 = Task::factory()->create();

    $response = $this->postJson("/api/tasks/{$task1->id}/dependencies", [
        'dependency_task_id' => $task2->id,
    ]);

    $response->assertStatus(201);
});

