<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Görev Kullanıcıya mı Ait Kontrolü
    private function ownedTask(Request $request, Task $task): Task
    {
        abort_unless((int) $task->user_id === (int) $request->user()->id, 404);

        return $task;
    }
}