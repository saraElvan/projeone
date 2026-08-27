<div class="table-responsive">
    <table class="table table-hover align-middle bg-white rounded shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Durum</th>
                <th>Başlık</th>
                <th>Açıklama</th>
                <th>Öncelik</th>
                <th class="text-end">İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>
                        <span class="badge {{ $task->status === 'done' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $task->status === 'done' ? 'Tamamlandı' : 'Bekliyor' }}
                        </span>
                    </td>
                    <td class="fw-semibold">{{ $task->title }}</td>
                    <td class="text-muted">{{ Str::limit($task->description, 50) }}</td>
                    <td>
                        @if($task->priority === 'high')
                            <span class="badge bg-danger">Yüksek</span>
                        @elseif($task->priority === 'medium')
                            <span class="badge bg-primary">Orta</span>
                        @else
                            <span class="badge bg-secondary">Düşük</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-info me-1">Detay</a>
                        
                        <!-- EDIT BUTONU -->
                        <button type="button" 
                                class="btn btn-sm btn-outline-primary me-1 edit-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editTaskModal-{{ $task->id }}">
                            Düzenle
                        </button>

                        <button type="button" 
                                class="btn btn-sm btn-outline-danger delete-btn" 
                                data-url="{{ route('tasks.destroy', $task) }}">
                            Sil
                        </button>
                    </td>
                </tr>

                <!-- EDIT TASK MODAL (EKSİKSİZ FORM) -->
                <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Görev Düzenle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body text-start">
                                    <!-- Title -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Başlık</label>
                                        <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                                    </div>

                                    <!-- Priority, Due Date, Status (Üçlü Yan Yana Akış) -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Öncelik</label>
                                            <select name="priority" class="form-select">
                                                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Düşük</option>
                                                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Orta</option>
                                                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Yüksek</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Bitiş Tarihi</label>
                                            <input type="date" name="due_date" class="form-control" value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Durum</label>
                                            <select name="status" class="form-select">
                                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Bekliyor</option>
                                                <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Tamamlandı</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Notlar</label>
                                        <textarea name="notes" class="form-control" rows="2" placeholder="Görev ile ilgili özel notlar...">{{ $task->notes }}</textarea>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Açıklama</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Görev detayları...">{{ $task->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-dark px-4">Güncelle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Aramanızla eşleşen hiçbir görev bulunamadı.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>