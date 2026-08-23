@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">Tüm Görevler: <span id="count-all" class="fw-bold">{{ $counts['all'] ?? 0 }}</span></div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">Bekleyenler: <span id="count-pending" class="fw-bold">{{ $counts['pending'] ?? 0 }}</span></div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">Tamamlananlar: <span id="count-done" class="fw-bold">{{ $counts['done'] ?? 0 }}</span></div>
    </div>
</div>

<div class="card p-3 mb-4">
    <form id="filter-form" class="row g-2">
        <input type="hidden" name="status" id="filter-status" value="">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Görevlerde ara...">
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">+ Yeni Görev</button>
        </div>
    </form>
</div>

<div id="tasks-content">
    @include('tasks.partials.table')
</div>

<script>
async function fetchTasks(options = {}) {
    const form = document.getElementById('filter-form');
    const params = new URLSearchParams(new FormData(form));
    const response = await fetch(`{{ route('tasks.data') }}?${params.toString()}`, {
        headers: { 'Accept': 'application/json' }
    });
    const payload = await response.json();
    document.getElementById('tasks-content').innerHTML = payload.html;
}

document.addEventListener('click', async function(e) {
    if (e.target.classList.contains('delete-btn')) {
        const result = await Swal.fire({ title: 'Silmek istediğine emin misin?', icon: 'warning', showCancelButton: true });
        if (result.isConfirmed) {
            await fetch(e.target.dataset.url, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            await fetchTasks();
        }
    }
});
</script>
@endsection