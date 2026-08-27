@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Görev Paneli</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            Yeni Görev Ekle
        </button>
    </div>

    <!-- Toast Bildirimi -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    İşlem başarılı.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Görev Listesi Tablosu -->
    <div id="tasksTableContainer">
        @include('tasks.partials.table')
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Görev</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createTaskForm">
                @csrf
                <div class="modal-body">
                    <div id="createErrorBox" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label class="form-label">Başlık</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Beklemede (Pending)</option>
                            <option value="done">Tamamlandı (Done)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Öncelik (Priority)</label>
                        <select name="priority" class="form-select" required>
                            <option value="low">Düşük (Low)</option>
                            <option value="medium" selected>Orta (Medium)</option>
                            <option value="high">Yüksek (High)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Görev Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTaskForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editTaskId" name="id">
                <div class="modal-body">
                    <div id="editErrorBox" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label class="form-label">Başlık</label>
                        <input type="text" id="editTitle" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea id="editDescription" name="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select id="editStatus" name="status" class="form-select" required>
                            <option value="pending">Beklemede (Pending)</option>
                            <option value="done">Tamamlandı (Done)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Öncelik (Priority)</label>
                        <select id="editPriority" name="priority" class="form-select" required>
                            <option value="low">Düşük (Low)</option>
                            <option value="medium">Orta (Medium)</option>
                            <option value="high">Yüksek (High)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const createModal = new bootstrap.Modal(document.getElementById('createTaskModal'));
    const editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
    const toastEl = document.getElementById('liveToast');
    const toast = new bootstrap.Toast(toastEl);

    function showToast(message) {
        document.getElementById('toastMessage').innerText = message;
        toast.show();
    }

    async function fetchTasks() {
        const response = await fetch('/tasks', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const html = await response.text();
        document.getElementById('tasksTableContainer').innerHTML = html;
    }

    // CREATE TASK AJAX
    document.getElementById('createTaskForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;
        const errorBox = document.getElementById('createErrorBox');
        errorBox.classList.add('d-none');

        const formData = new FormData(form);

        try {
            const response = await fetch('/tasks', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.status === 422) {
                const payload = await response.json();
                errorBox.innerHTML = Object.values(payload.errors || {}).flat()
                    .map((err) => `<div>${err}</div>`).join('');
                errorBox.classList.remove('d-none');
                return;
            }

            if (response.ok) {
                createModal.hide();
                showToast('Görev başarıyla eklendi.');
                await fetchTasks();
                form.reset();
            } else {
                // AJAX değil de düz Redirect döndüyse sayfayı yenile
                window.location.reload();
            }
        } catch (err) {
            window.location.reload();
        }
    });
});
</script>
@endsection