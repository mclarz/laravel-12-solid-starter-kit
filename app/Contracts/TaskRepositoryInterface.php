<?php

namespace App\Contracts;

use App\Models\Task;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    /**
     * Get all tasks.
     *
     * @return Collection
     */
    public function all(): Collection;
    /**
     * Get a task by ID.
     *
     * @param int $id
     * @return Task|null
     */
    public function find(int $id): ?Task;
    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task;

    /**
     * Update an existing task.
     *
     * @param Task $task
     * @param array $data
     * @return Task
     */

    public function update(Task $task, array $data): Task;
    /**
     * Delete a task.
     *
     * @param Task $task
     * @return void
     */

    public function delete(Task $task): void;
}
