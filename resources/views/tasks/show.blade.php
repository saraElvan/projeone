@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Görev Listesine Dön
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">{{ $task->title }}</h5>
            <span class="badge {{ $task->status === 'done' ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ $task->status === 'done' ? 'Tamamlandı' : 'Bekliyor' }}
            </span>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h6 class="text-muted small">AÇIKLAMA</h6>
                <p class="card-text">{{ $task->description ?? 'Açıklama girilmemiş.' }}</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted small">ÖNCELİK</h6>
                    @if($task->priority === 'high')
                        <span class="badge bg-danger">Yüksek</span>
                    @elseif($task->priority === 'medium')
                        <span class="badge bg-primary">Orta</span>
                    @else
                        <span class="badge bg-secondary">Düşük</span>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted small">OLUŞTURULMA TARİHİ</h6>
                    <p class="mb-0 text-muted">{{ $task->created_at ? $task->created_at->format('d.m.Y H:i') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection