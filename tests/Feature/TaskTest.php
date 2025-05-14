<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

/**
 * Test the create task
 */


beforeEach(function () {
    Sanctum::actingAs(User::factory()->create());
});

it('can create a task', function () {
    $response = $this->postJson('/api/tasks', [
        'title' => 'Buy groceries',
        'description' => 'Milk, Bread, Eggs',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'title' => 'Buy groceries',
                'description' => 'Milk, Bread, Eggs',
            ]
        ]);

    expect(Task::where('title', 'Buy groceries')->exists())->toBeTrue();
});
