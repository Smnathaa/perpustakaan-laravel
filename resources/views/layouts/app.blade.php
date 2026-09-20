<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard') · Pustaka</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}">
            <span class="logo">P</span>
            Pustaka<span class="brand-dot">.</span>
        </a>

        <p class="caption">SISTEM INFORMASI PERPUSTAKAAN</p>

        <nav>
            <a
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                href="{{ route('dashboard') }}"
            >
                ◫ &nbsp; Dashboard
            </a>

            <a
                class="{{ request()->routeIs('books.*') && !request()->routeIs('books.report') ? 'active' : '' }}"
                href="{{ route('books.index') }}"
            >
                ▤ &nbsp; Data buku
            </a>

            <a
                class="{{ request()->routeIs('categories.*') ? 'active' : '' }}"
                href="{{ route('categories.index') }}"
            >
                ▦ &nbsp; Kategori
            </a>

            <a
                class="{{ request()->routeIs('books.report') ? 'active' : '' }}"
                href="{{ route('books.report') }}"
            >
                ▧ &nbsp; Laporan
            </a>
        </nav>

        <div class="sidebar-bottom">
            <strong>Pustaka</strong>
            <small>Pengelolaan koleksi buku</small>
        </div>
    </aside>

    <main>
        <header>
            <span>Ruang kelola / @yield('title', 'Dashboard')</span>
            <span>{{ now()->format('d M Y') }}</span>
        </header>

        @if(session('success'))
            <div role="status" class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="alert error">
                <strong>Periksa kembali data:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

        <footer>
            Pustaka · Sistem Informasi Data Buku Perpustakaan
        </footer>
    </main>

    <script>
        document.addEventListener('submit', function (event) {
            const message = event.target.dataset.confirm;

            if (message && !window.confirm(message)) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>