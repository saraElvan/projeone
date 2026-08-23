<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse min-vh-100 p-3 text-white">
                <h4 class="text-center text-white mb-4">Todo Pro</h4>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('tasks.index') }}" class="nav-link text-white active">Görevler</a>
                    </li>
                    <li>
                        <a href="{{ route('account.edit') }}" class="nav-link text-white">Hesabım</a>
                    </li>
                </ul>
                <hr>
                <form method="POST" action="{{ route('tasks.fill-demo') }}" class="ajax-action-form" data-success="Demo veriler eklendi.">
                    @csrf
                    <button class="btn btn-sm btn-outline-light w-100" type="submit">Fill Tasks</button>
                </form>
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>