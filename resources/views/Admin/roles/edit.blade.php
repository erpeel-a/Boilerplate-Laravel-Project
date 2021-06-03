@extends('layouts.main')
@section('title', 'Edit Roles')
@section('content')
<div class="section-header">
  <h1>Edit Role</h1>
</div>
<div class="card shadow card-body">
  <form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="name">Name</label>
      <input
        type="text"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        name="name"
        value="{{ $role->name }}"
        autofocus=""
      />
      @error('name')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group form-check">
      <label>Permission</label><br>
      @foreach($permission as $value)
      <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
          {{ $value->name }}</label>
      <br/>
      @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('roles.index')}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk meninggalkan halaman ini ?')">kembali</a>
  </form>
</div>
@endsection