<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->validated());

        return response()->json([
            'message' => 'Görev başarıyla oluşturuldu.',
            'task' => $task
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->ownedTask($request, $task);

        $task->update($request->safe()->only([
            'title', 'description', 'notes', 'status', 'priority', 'due_date',
        ]));

        return response()->json([
            'message' => 'Görev başarıyla güncellendi.',
            'task' => $task
        ]);
    }

    private function ownedTask(Request $request, Task $task): Task
    {
        abort_unless((int) $task->user_id === (int) $request->user()->id, 404);

        return $task;
    }
}