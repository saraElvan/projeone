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
                    <td class="fw-semibold">
                        <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark">
                            {{ $task->title }}
                        </a>
                    </td>
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
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-info me-1">
                            Detay
                        </a>
                        <!-- Delete Button (AJAX + SweetAlert2 Compatible) -->
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger delete-btn" 
                                data-url="{{ route('tasks.destroy', $task) }}">
                            Sil
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        Aramanızla eşleşen hiçbir görev bulunamadı.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Sayfalama (Pagination) -->
<div id="paginationWrapper" class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted small">
        Toplam {{ $tasks->total() ?? count($tasks) }} kayıttan 
        {{ $tasks->firstItem() ?? 1 }} - {{ $tasks->lastItem() ?? count($tasks) }} arası gösteriliyor.
    </div>
    <div>
        @if(method_exists($tasks, 'links'))
            {{ $tasks->links() }}
        @endif
    </div>
</div>