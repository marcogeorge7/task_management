<?php

use Tests\TestCase;

it('can create a project', function () {
    $data = ['name' => 'New Project', 'description' => 'Test description'];

    $response = $this->postJson('/api/projects', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['name' => 'New Project']);
});

