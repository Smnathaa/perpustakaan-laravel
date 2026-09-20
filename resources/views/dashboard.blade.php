@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="heading">
        <div>
            <span class="eyebrow">RINGKASAN PERPUSTAKAAN</span>

            <h1>Selamat datang di Pustaka.</h1>
            <p>Pantau koleksi dan kelola buku dalam satu tempat.</p>
        </div>

        <a class="btn" href="{{ route('books.create') }}">
            + Tambah buku
        </a>
    </div>

    <section class="hero">
        <div>
            <span class="tag">KOLEKSI YANG TERORGANISASI</span>

            <h2>
                Setiap buku punya tempat.<br>
                Setiap pengetahuan punya arti.
            </h2>

            <p>
                Mulai dari satu buku, bangun perpustakaan yang lebih baik.
            </p>

            <a href="{{ route('books.index') }}">
                Jelajahi koleksi →
            </a>
        </div>

        <div class="book-art" aria-hidden="true">
            <i>ILMU</i>
            <i>KARYA</i>
            <i>CERITA</i>
        </div>
    </section>

    <div class="stats">
        @foreach([
            ['Judul buku', $titles, 'Seluruh judul terdaftar'],
            ['Total eksemplar', $copies, 'Jumlah fisik dalam koleksi'],
            ['Kategori', $categoryCount, 'Kelompok koleksi'],
            ['Stok kosong', $empty, 'Judul dengan jumlah nol'],
        ] as [$label, $value, $hint])
            <article class="stat">
                <span>{{ $label }}</span>

                <strong>
                    {{ number_format($value, 0, ',', '.') }}
                </strong>

                <small>{{ $hint }}</small>
            </article>
        @endforeach
    </div>

    <section class="panel">
        <div class="panel-head">
            <h2>Buku terbaru</h2>

            <a href="{{ route('books.index') }}">
                Lihat semua →
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>BUKU</th>
                        <th>KATEGORI</th>
                        <th>RAK</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recent as $book)
                        <tr>
                            <td>
                                <a
                                    class="book-title"
                                    href="{{ route('books.show', $book) }}"
                                >
                                    {{ $book->title }}
                                </a>

                                <small>
                                    {{ $book->author }} · {{ $book->code }}
                                </small>
                            </td>

                            <td>
                                <span class="badge">
                                    {{ $book->category->name }}
                                </span>
                            </td>

                            <td>{{ $book->shelf }}</td>

                            <td>{{ $book->quantity }} eks.</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">
                                Belum ada buku. Tambahkan koleksi pertamamu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection