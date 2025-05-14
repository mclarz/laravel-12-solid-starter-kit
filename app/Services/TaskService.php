<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{

    protected $taskRepository;
    /**
     * TaskService constructor.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get all tasks.
     * return Task[]
     */
    public function getAllTasks()
    {
        // handle business logic here
        return $this->taskRepository->all();
    }

    public function getTaskById(string $id)
    {
        // handle business logic here
        return $this->taskRepository->find($id);
    }

    /**
     * Create a new task.
     * return Task
     * @param array $data
     */
    public function createTask(array $data)
    {
        // handle business logic here
        return $this->taskRepository->create($data);
    }


    /**
     * Update an existing task.
     */
    public function updateTask(Task $task, array $data)
    {
        // handle business logic here
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(Task $task)
    {
        // handle business logic here
        return $this->taskRepository->delete($task);
    }
}
