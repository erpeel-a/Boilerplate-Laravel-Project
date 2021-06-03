@extends('layouts.main')
@section('title', 'Informasi')
@section('content')
<div class="section-header">
  <h1>Informasi</h1>
</div>
<div class="d-flex justify-content-between align-items-start mb-2">
  <h2 class="section-title m-0 mb-4">
      Data Informasi
  </h2>
  <div class="float-right">
    @can('post-create')
    <a href="{{ route('post.create') }}" class="btn btn-primary mb-3">Tambah</a>
    @endcan
    @can('trash-post')
    <a href="{{ route('post.trash') }}" class="btn btn-danger mb-3" data-toggle="tooltip" data-placement="right" title="Tempat Sampah"><i class="fas fa-trash"></i></a>
    @endcan
  </div>
</div>
@include('components.flash-message')
<div class="card shadow card-body">
  <div class="table-responsive">
    <table class="table table-striped" id="table-article">
      <thead>                                 
        <tr>
          <th class="text-center">
            #
          </th>
          <th>Thumbnail</th>
          <th>Judul</th>
          <th>Status</th>
          <th>Penulis</th>
          <th>Kategori</th>
          <th>Di buat pada</th>
          <th>Aksi</th>
          @if (auth()->user()->can('publish-post') || auth()->user()->can('archive-article'))
          <th>publish / Archive</th>
          @endif
        </tr>
      </thead>
      <tbody>                                 
        @foreach ($data as $post)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>
            <img src="{{ asset($post->thumbnail) }}" height="70px" alt="thumbnail post">
          </td>
          <td>{!! $post->author === auth()->user()->id ? '<i class="fas fa-bookmark text-primary" data-toggle="tooltip" data-placement="top" title="Artikel Anda"></i>' : '' !!}  {{ $post->title }}</td>
          <td>
            @if ($post->status === 'draft')
            <span class="badge badge-warning">{{ $post->status }}</span>
            @elseif ($post->status === 'archive')
            <span class="badge badge-primary">{{ $post->status }}</span>
            @elseif ($post->status === 'publish')
            <span class="badge badge-success">{{ $post->status }}</span>
            @endif
          </td>
          <td>{{$post->authors->name}}</td>
          <td>{{ $post->category->name }}</td>
          <td>{{date('d-m-Y', strtotime($post->created_at))}}</td>
          <td>
            @can('post-edit')
            <a href="{{ route('post.edit', Crypt::encrypt($post->id)) }}" class="btn btn-info my-2"><i class="fas fa-edit" data-toggle="tooltip" data-placement="right" title="Ubah Data"></i></a>
            @endcan
            @can('post-delete')
            <form id="extra-delete" action="{{ route('post.destroy', $post->id) }}" onsubmit="return confirm('Apakah anda yakin untuk menghapus data artikel ini?')" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button href="{{ route('post.destroy', $post->id) }}" class="btn btn-danger my-2" data-toggle="tooltip" data-placement="right" title="Hapus Data"><i class="fas fa-trash"></i></button>
            </form>
            @endcan
          </td>
          @if (auth()->user()->can('publish-post') || auth()->user()->can('archive-post'))
          <td>
            @if ($post->status === 'draft' || $post->status === 'archive')
            <a href="{{ route('publish.post', Crypt::encrypt($post->id)) }}" onclick="return confirm('Apakah anda yakin untuk membuat informasi ini terpublish ?')" class="btn btn-success">publish</a>
            @elseif ($post->status === 'publish')
            <a href="{{ route('archive.post', Crypt::encrypt($post->id)) }}" onclick="return confirm('Apakah anda yakin untuk mengarsipkan informasi ini ?')" class="btn btn-primary">archive</a>
            @endif
          </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
@include('components.data-table')

