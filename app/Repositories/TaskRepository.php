<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{

    /**
     * Get all tasks.
     *
     * @return Collection
     */

    public function all(): Collection
    {
        return Task::all();
    }

    /**
     * Get a task by ID.
     *
     * @param int $id
     * @return Task|null
     */

    public function find(int $id): Task
    {
        return Task::findOrFail($id);
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Update an existing task.
     *
     * @param Task $task
     * @param array $data
     * @return Task
     */
    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    /**
     * Delete a task.
     *
     * @param Task $task
     * @return void
     */
    public function delete(Task $task): void
    {
        $task->delete();
    }
}
