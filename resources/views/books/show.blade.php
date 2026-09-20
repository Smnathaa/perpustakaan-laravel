@extends('layouts.app')

@section('title', 'Detail buku')

@section('content')
    <div class="heading">
        <div>
            <span class="eyebrow">{{ $book->code }}</span>
            <h1>{{ $book->title }}</h1>
            <p>{{ $book->author }}</p>
        </div>

        <a class="btn" href="{{ route('books.edit', $book) }}">
            Edit buku
        </a>
    </div>

    <section class="panel form-panel">
        <dl class="details">
            @foreach([
                'ISBN' => $book->isbn,
                'Kategori' => $book->category->name,
                'Penerbit' => $book->publisher,
                'Tahun terbit' => $book->year,
                'Lokasi rak' => $book->shelf,
                'Jumlah eksemplar' => $book->quantity,
            ] as $key => $value)
                <div>
                    <dt>{{ $key }}</dt>
                    <dd>{{ $value ?? '—' }}</dd>
                </div>
            @endforeach
        </dl>

        <h2>Deskripsi</h2>

        <p class="description">
            {{ $book->description ?: 'Belum ada deskripsi.' }}
        </p>

        <a href="{{ route('books.index') }}">
            ← Kembali ke koleksi
        </a>
    </section>
@endsection