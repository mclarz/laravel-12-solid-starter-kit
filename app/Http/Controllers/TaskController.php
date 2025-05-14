<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(TaskService $taskService)
    {
        try {
            $tasks = $taskService->getAllTasks();
            return $this->success($tasks);
        } catch (\Exception $e) {
            return $this->serverError('Failed to retrieve tasks', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request, TaskService $taskService)
    {
        try {
            $task = $taskService->createTask($request->validated());
            return $this->success('Task created successfully', $task, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->serverError('Failed to create task: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskService $taskService, string $id)
    {
        $task = $taskService->getTaskById($id);
        return $this->success($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskService $taskService, UpdateTaskRequest $request, Task $task)
    {
        try {
            $task = $taskService->updateTask($task, $request->validated());
            return $this->success('Task updated successfully', $task);
        } catch (\Exception $e) {
            return $this->serverError('Failed to update task: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskService $taskService, Task $task)
    {
        try {
            $taskService->deleteTask($task);
            return $this->success('Task deleted successfully');
        } catch (\Exception $e) {
            return $this->serverError('Failed to delete task: ' . $e->getMessage());
        }
    }
}
