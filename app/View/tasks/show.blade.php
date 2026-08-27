@extends('layouts.app')

@section('content')
<div class="container py-3">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="h4 fw-bold mb-1">Task Details</h2>
        <p class="text-muted small mb-0">Full information for this task</p>
    </div>

    <!-- Main Details Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h3 class="h3 fw-bold mb-1">{{ $task->title }}</h3>
                    <p class="text-muted small mb-0">Created {{ $task->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">Back</a>
            </div>

            <!-- Dynamic Badges -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="badge {{ $task->status === 'done' ? 'badge-done' : 'badge-pending' }}">
                    {{ ucfirst($task->status) }}
                </span>
                <span class="badge {{ $task->priority === 'high' ? 'badge-priority-high' : ($task->priority === 'medium' ? 'badge-priority-medium' : 'badge-priority-low') }}">
                    {{ ucfirst($task->priority) }} Priority
                </span>
                @if($task->due_date)
                    <span class="badge badge-soft">Due {{ $task->due_date->format('Y-m-d') }}</span>
                @endif
            </div>

            <!-- Notes Section -->
            <div class="mb-4">
                <h6 class="fw-bold text-dark mb-2">Notes</h6>
                <p class="text-secondary small mb-0">{{ $task->notes ?? 'No notes provided.' }}</p>
            </div>

            <!-- Description Section -->
            <div class="mb-5">
                <h6 class="fw-bold text-dark mb-2">Description</h6>
                <p class="text-secondary small mb-0">{{ $task->description ?? 'No description provided.' }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.index') }}" class="btn btn-dark rounded-3 px-4">Open Board</a>
                <button id="deleteTaskBtn" type="button" class="btn btn-outline-danger rounded-3 px-4">Delete</button>
            </div>

            <!-- Hidden Delete Form (CSRF + DELETE) -->
            <form id="deleteTaskForm" method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 Modal Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('deleteTaskBtn')?.addEventListener('click', async () => {
        const result = await Swal.fire({
            title: 'Delete this task?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#6c757d'
        });

        if (result.isConfirmed) {
            document.getElementById('deleteTaskForm').submit();
        }
    });
</script>
@endsection