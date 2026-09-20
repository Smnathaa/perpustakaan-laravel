@extends('layouts.app')
@section('title',$book->exists?'Edit buku':'Tambah buku')
@section('content')
<div class="heading"><div><span class="eyebrow">KELOLA KOLEKSI</span><h1>{{ $book->exists?'Edit buku':'Tambah buku baru' }}</h1><p>Lengkapi informasi buku. Tanda * wajib diisi.</p></div><a href="{{ route('books.index') }}">← Kembali</a></div>
@if($categories->isEmpty())<div class="alert error">Buat <a href="{{ route('categories.index') }}">kategori</a> terlebih dahulu sebelum menambahkan buku.</div>@endif
<form class="panel form-panel" method="POST" action="{{ $book->exists?route('books.update',$book):route('books.store') }}">@csrf @if($book->exists) @method('PUT') @endif
<div class="form-grid">
@foreach(['code'=>['Kode buku *','text',30],'isbn'=>['ISBN','text',20],'title'=>['Judul buku *','text',255],'author'=>['Penulis *','text',255],'publisher'=>['Penerbit','text',255],'year'=>['Tahun terbit *','number',4],'shelf'=>['Lokasi rak *','text',50],'quantity'=>['Jumlah eksemplar *','number',7]] as $field=>[$label,$type,$max])<label>{{ $label }}<input name="{{ $field }}" type="{{ $type }}" value="{{ old($field,$book->$field) }}" @if(!in_array($field,['isbn','publisher'])) required @endif @if($type==='text') maxlength="{{ $max }}" @elseif($field==='year') min="1000" max="{{ date('Y')+1 }}" @else min="0" max="1000000" @endif></label>@endforeach
<label>Kategori *<select name="category_id" required><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$book->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></label><label class="span-two">Deskripsi<textarea name="description" rows="4" maxlength="5000">{{ old('description',$book->description) }}</textarea></label></div><div class="form-bottom"><a class="btn secondary" href="{{ route('books.index') }}">Batal</a><button class="btn" @disabled($categories->isEmpty())>Simpan buku</button></div></form>
@endsection
