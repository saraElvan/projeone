<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Staj Projesi - Görev Yönetimi</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS (Sekme Stilleri) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">Görev Paneli</a>
            @auth
                <div class="d-flex align-items-center">
                    <span class="text-white me-3">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Çıkış Yap</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 Silme Mantığı -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', async function (e) {
            const deleteBtn = e.target.closest('.delete-btn');
            if (deleteBtn) {
                e.preventDefault();
                const deleteUrl = deleteBtn.dataset.url;

                const result = await Swal.fire({
                    title: 'Delete this task?',
                    text: "You won't be able to undo this.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0f766e',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                });

                if (result.isConfirmed) {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').content;
                        const response = await fetch(deleteUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ _method: 'DELETE' })
                        });

                        if (response.ok) {
                            Swal.fire('Deleted!', 'Görev silindi.', 'success').then(() => {
                                window.location.reload();
                            });
                        }
                    } catch (err) {
                        Swal.fire('Error!', 'Silme işlemi sırasında hata oluştu.', 'error');
                    }
                }
            }
        });
    });
    </script>
</body>
</html>