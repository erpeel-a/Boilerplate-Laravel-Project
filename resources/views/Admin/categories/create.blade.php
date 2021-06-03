@extends('layouts.main')
@section('title', 'Tambah Kategori')
@section('content')
<div class="section-header">
  <h1>Tambah Kategori</h1>
</div>
<div class="card shadow card-body">
  <form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">Name</label>
      <input
        type="text"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        name="name"
        autofocus=""
      />
      @error('name')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('categories.index')}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk meninggalkan halaman ini ?')">kembali</a>
  </form>
</div>
@endsection