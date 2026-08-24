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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">+ Yeni Görev</button>
        </div>
    </form>
</div>

<div id="tasks-content">
    @include('tasks.partials.table')
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="create-task-form" action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Görev Oluştur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="create-error-box" class="alert alert-danger d-none"></div>
                    <div class="mb-3">
                        <label class="form-label">Başlık</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Öncelik</label>
                        <select name="priority" class="form-select">
                            <option value="low">Düşük</option>
                            <option value="medium" selected>Orta</option>
                            <option value="high">Yüksek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-select">
                            <option value="pending" selected>Bekliyor</option>
                            <option value="done">Tamamlandı</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showToast(message) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 3000
    });
}

async function fetchTasks(options = {}) {
    const form = document.getElementById('filter-form');
    const params = new URLSearchParams(new FormData(form));
    const response = await fetch(`{{ route('tasks.data') }}?${params.toString()}`, {
        headers: { 'Accept': 'application/json' }
    });
    const payload = await response.json();
    document.getElementById('tasks-content').innerHTML = payload.html;
}

// Form Gönderimi ve 422 Validation Yönetimi
document.getElementById('create-task-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const errorBox = document.getElementById('create-error-box');
    errorBox.classList.add('d-none');
    errorBox.innerHTML = '';

    const response = await fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: new FormData(form)
    });

    const payload = await response.json();

    if (response.status === 422) {
        errorBox.innerHTML = Object.values(payload.errors || {}).flat().map(e => `<div>${e}</div>`).join('');
        errorBox.classList.remove('d-none');
        return;
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById('createTaskModal'));
    modal.hide();
    showToast(payload.message || 'Görev başarıyla eklendi.');
    await fetchTasks();
    form.reset();
});

document.addEventListener('click', async function(e) {
    if (e.target.classList.contains('delete-btn')) {
        const result = await Swal.fire({ title: 'Silmek istediğinize emin misiniz?', icon: 'warning', showCancelButton: true });
        if (result.isConfirmed) {
            const response = await fetch(e.target.dataset.url, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            const payload = await response.json();
            showToast(payload.message || 'Görev silindi.');
            await fetchTasks();
        }
    }
});
</script>
@endsection