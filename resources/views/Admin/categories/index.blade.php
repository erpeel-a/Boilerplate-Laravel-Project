@extends('layouts.main')
@section('title', 'Kategori')
@section('content')
<div class="section-header">
  <h1>Kategori</h1>
</div>
<div class="d-flex justify-content-between align-items-start mb-2">
  <h2 class="section-title m-0 mb-4">
      Data Kategori
  </h2>
  @can('category-create')
  <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah</a>
  @endcan
</div>
@include('components.flash-message')
<div class="card shadow card-body">
  <div class="table-responsive">
    <table class="table table-striped" id="table-category">
      <thead>                                 
        <tr>
          <th class="text-center">
            #
          </th>
          <th>Nama Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>                                 
        @foreach ($data as $category)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $category->name }}</td>
          <td>
            @can('category-edit')
            <a href="{{ route('categories.edit', Crypt::encrypt($category->id)) }}" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="right" title="Ubah Data"></i></a>
            @endcan
            @can('category-delete')
            <form id="extra-delete" action="{{ route('categories.destroy', $category->id) }}" onsubmit="return confirm('Apakah anda yakin untuk menghapus data kategori ini?')" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Hapus Data"><i class="fas fa-trash"></i></button>
            </form>
            @endcan
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
@include('components.data-table')