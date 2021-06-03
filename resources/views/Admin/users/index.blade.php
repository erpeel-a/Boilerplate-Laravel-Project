@extends('layouts.main')
@section('title', 'Pengguna')
@section('content')
<div class="section-header">
  <h1>Pengguna</h1>
</div>
<div class="d-flex justify-content-between align-items-start mb-2">
  <h2 class="section-title m-0 mb-4">
      Data Pengguna
  </h2>
  @can('user-create')
  <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna Baru</a>
  @endcan
</div>
@include('components.flash-message')
<div class="card shadow card-body">
  <div class="table-responsive">
    <table class="table table-striped" id="table-user">
      <thead>                                 
        <tr>
          <th class="text-center">
            #
          </th>
          <th>Nama</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>                                 
        @foreach ($data as $user)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $user->name }}</td>
          <td>{{'@'.$user->username}}</td>
          <td>{{ $user->email }}</td>
          <td>
            @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
              <span
                class="badge badge-info"
              >
                {{ $v }}
              </span>
            @endforeach
            @can('change-user-role')
            <a href="{{ route('users.edit', Crypt::encrypt($user->id)) }}" class="btn btn-primary btn-sm my-2 mx-2" data-toggle="tooltip" data-placement="right" title="Ganti role pengguna"><i class="fas fa-cog"></i></a>
            @endcan
            @endif
          </td>
          <td>
            @can('user-delete')
            <form id="extra-delete" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Apakah anda yakin untuk menghapus data pengguna tersebut ?')" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger my-2 mx-2"><i class="fas fa-trash"></i></a>
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