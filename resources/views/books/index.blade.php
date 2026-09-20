@extends('layouts.app')

@section('title', 'Data buku')

@section('content')
    <div class="heading">
        <div>
            <span class="eyebrow">KATALOG PERPUSTAKAAN</span>
            <h1>Data buku</h1>
            <p>{{ $books->total() }} judul ditemukan dalam koleksi.</p>
        </div>

        <a class="btn" href="{{ route('books.create') }}">
            + Tambah buku
        </a>
    </div>

    <form
        class="filters"
        method="GET"
        action="{{ route('books.index') }}"
    >
        <label class="search">
            Cari buku
            <input
                name="q"
                placeholder="Judul, penulis, kode, atau ISBN…"
                value="{{ request('q') }}"
                maxlength="200"
            >
        </label>

        <label>
            Kategori
            <select name="category">
                <option value="">Semua kategori</option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(request('category') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </label>

        <button type="submit" class="btn">Cari</button>

        <a class="btn secondary" href="{{ route('books.index') }}">
            Reset
        </a>
    </form>

    <section class="panel">
        <div class="panel-head">
            <h2>Koleksi buku</h2>

            <a href="{{ route('books.report', request()->only('q', 'category')) }}">
                Cetak hasil →
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>KODE / BUKU</th>
                        <th>KATEGORI</th>
                        <th>TAHUN</th>
                        <th>RAK</th>
                        <th>JUMLAH</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>
                                <small>{{ $book->code }}</small>

                                <a
                                    class="book-title"
                                    href="{{ route('books.show', $book) }}"
                                >
                                    {{ $book->title }}
                                </a>

                                <small>{{ $book->author }}</small>
                            </td>

                            <td>
                                <span class="badge">
                                    {{ $book->category->name }}
                                </span>
                            </td>

                            <td>{{ $book->year }}</td>
                            <td>{{ $book->shelf }}</td>

                            <td>
                                <span class="{{ $book->quantity === 0 ? 'danger' : '' }}">
                                    {{ $book->quantity }} eks.
                                </span>
                            </td>

                            <td>
                                <div class="actions">
                                    <a href="{{ route('books.edit', $book) }}">
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('books.destroy', $book) }}"
                                        data-confirm="Hapus buku ini? Tindakan ini tidak dapat dibatalkan."
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-btn danger"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Tidak ada buku yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <span>
                Halaman {{ $books->currentPage() }}
                dari {{ $books->lastPage() }}
            </span>

            <div>
                @if($books->previousPageUrl())
                    <a href="{{ $books->previousPageUrl() }}">
                        ← Sebelumnya
                    </a>
                @endif

                @if($books->nextPageUrl())
                    <a href="{{ $books->nextPageUrl() }}">
                        Berikutnya →
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection