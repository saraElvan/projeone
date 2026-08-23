<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Staj Projesi</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; text-align: center; padding-top: 50px; }
        .card { background: white; width: 50%; margin: auto; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; }
        p { color: #7f8c8d; }
        input[type="text"] { padding: 8px; width: 60%; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 12px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Staj Projem Başarıyla Başladı! 🚀</h1>
        <p>Laravel Blade şablonu üzerinden ilk görünümümüzü yüklüyoruz.</p>

        <!-- Başarı Mesajı -->
        @if(session('mesaj'))
            <p style="color: green; font-weight: bold;">{{ session('mesaj') }}</p>
        @endif

        <!-- Validation Hata Mesajı -->
        @if($errors->has('baslik'))
            <p style="color: red; font-weight: bold;">{{ $errors->first('baslik') }}</p>
        @endif

        <!-- 4. Gün: Yeni Görev Ekleme Formu (POST) -->
        <form action="/gorev-ekle" method="POST" style="margin: 20px 0;">
            @csrf
            <input type="text" name="baslik" placeholder="Yeni görev başlığı yazın...">
            <button type="submit">Ekle</button>
        </form>

        <h3>Bugün Tamamlanan Görevler:</h3>
        <ul style="list-style: none; padding: 0;">
            @foreach($gorevler as $gorev)
                <li style="background: #eef2f7; margin: 5px 0; padding: 8px; border-radius: 4px;">
                    ✅ {{ $gorev }}
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>