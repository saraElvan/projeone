<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user() ?? User::first();

        // 21. Gün Filtre Değişkenlerini İsteğe (Request) Göre Yakalama
        $tab = $request->get('tab', 'all');
        $q = $request->get('q');
        $status = $request->get('status');
        $perPage = (int) $request->get('per_page', 10);

        // Kullanıcıya ait görevlerin sorgusu
        $query = $user ? $user->tasks() : Task::query();

        // 1. Sekme Filtresi (All / Pending / Done)
        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($tab === 'done') {
            $query->where('status', 'done');
        }

        // 2. Arama Filtresi (Başlık, açıklama ve notlarda arar)
        if (!empty($q)) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('title', 'like', "%{$q}%")
                         ->orWhere('description', 'like', "%{$q}%")
                         ->orWhere('notes', 'like', "%{$q}%");
            });
        }

        // 3. Dropdown Status Filtresi
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Sayfalama (Pagination) ve URL parametrelerini koruma
        $tasks = $query->latest()->paginate($perPage)->withQueryString();

        return view('tasks.index', compact('tasks', 'tab', 'q', 'status', 'perPage'));
    }

    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,done'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $user = Auth::user() ?? User::first();

        if ($user) {
            $user->tasks()->create($data);
        }

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla eklendi.');
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,done'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($data);

        return back()->with('success', 'Görev güncellendi.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Görev silindi.');
    }
}