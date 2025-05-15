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

it('it can get all task', function () {
    Task::factory()->count(5)->create();

    $response = $this->getJson('/api/tasks');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);

    expect(Task::count())->toBe(5);
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


it('it can show specific task', function () {

    Task::factory()->create([
        'id' => 1,
        'title' => 'Buy groceries',
        'description' => 'Milk, Bread, Eggs',
    ]);

    $response = $this->getJson('/api/tasks/1');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);

    expect(Task::where('id', 1)->exists())->toBeTrue();
});

it('it can update a task', function () {

    $task = Task::factory()->create([
        'id' => 1,
        'title' => 'Buy groceries',
        'description' => 'Milk, Bread, Eggs',
    ]);

    $response = $this->putJson('/api/tasks/1', [
        'title' => 'Buy groceries',
        'description' => 'Milk, Bread, Eggs',
        'status' => 'completed'
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'title',
                'description',
                'status'
            ]
        ]);

    expect(Task::where('id', 1)->first()->status)->toBe('completed');
    expect(Task::where('id', 1)->first()->description)->toBe('Milk, Bread, Eggs');
    expect(Task::where('id', 1)->first()->title)->toBe('Buy groceries');
    expect(Task::where('id', 1)->exists())->toBeTrue();
});

it('it can delete a task', function () {

    $task = Task::factory()->create([
        'id' => 1,
        'title' => 'Buy groceries',
        'description' => 'Milk, Bread, Eggs',
    ]);

    $response = $this->deleteJson('/api/tasks/1');

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Task deleted successfully'
        ]);

    expect(Task::where('id', 1)->exists())->toBeFalse();
});
