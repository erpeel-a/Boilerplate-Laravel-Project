@extends('layouts.main')
@section('title', 'Ubah Profil')
@section('content')
<div class="section-header">
  <h1>Profile</h1>
</div>
<div class="section-body">
  <h2 class="section-title">Hi, {{ $user->name }}!</h2>
  <p class="section-lead">
    Ubah informasi tentang diri Anda di halaman ini.
  </p>

  <div class="card shadow">
    <form method="post" action="{{ route('user-profile.update', $user->id) }}">
      @csrf
      @method('PUT')
      <div class="card-header">
        <h4>Edit Profile</h4>
      </div>
      <div class="card-body">
        @include('components.flash-message')
        <div class="form-group">
          <label>Name</label>
          <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ $user->name }}"
          />
          @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label>Username</label>
          <input
            type="text"
            name="username"
            class="form-control @error('username') is-invalid @enderror"
            value="{{ $user->username }}" 
          />
          @error('usermane')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label>Email</label>
          <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ $user->email }}"
          />
          @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label>Kofirmasi Password</label>
          <input
            type="password"
            name="password"
            class="form-control @error('username') is-invalid @enderror"
            required
          />
          @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection