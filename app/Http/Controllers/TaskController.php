<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user() ?? User::first();

        $tab = $request->get('tab', 'all');
        $q = $request->get('q');
        $status = $request->get('status');
        $perPage = (int) $request->get('per_page', 10);

        $query = $user ? $user->tasks() : Task::query();

        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($tab === 'done') {
            $query->where('status', 'done');
        }

        if (!empty($q)) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('title', 'like', "%{$q}%")
                         ->orWhere('description', 'like', "%{$q}%")
                         ->orWhere('notes', 'like', "%{$q}%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $tasks = $query->latest()->paginate($perPage)->withQueryString();

        return view('tasks.index', compact('tasks', 'tab', 'q', 'status', 'perPage'));
    }

    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    public function store(Request $request): RedirectResponse|JsonResponse
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
        $task = null;

        if ($user) {
            $task = $user->tasks()->create($data);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Görev başarıyla eklendi.', 'task' => $task]);
        }

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla eklendi.');
    }

    public function update(Request $request, Task $task): RedirectResponse|JsonResponse
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

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Görev güncellendi.', 'task' => $task]);
        }

        return back()->with('success', 'Görev güncellendi.');
    }

    public function destroy(Request $request, Task $task): RedirectResponse|JsonResponse
    {
        $task->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Görev silindi.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Görev silindi.');
    }

    public function data(Request $request): JsonResponse
    {
        $user = Auth::user() ?? User::first();

        $tab = $request->get('tab', 'all');
        $q = $request->get('q');
        $status = $request->get('status');
        $perPage = (int) $request->get('per_page', 10);

        $query = $user ? $user->tasks() : Task::query();

        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($tab === 'done') {
            $query->where('status', 'done');
        }

        if (!empty($q)) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('title', 'like', "%{$q}%")
                         ->orWhere('description', 'like', "%{$q}%")
                         ->orWhere('notes', 'like', "%{$q}%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $tasks = $query->latest()->paginate($perPage)->withQueryString();

        $html = view('tasks.partials.table', compact('tasks'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}