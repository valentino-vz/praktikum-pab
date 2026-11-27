@extends('layout')
@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h1 class="mb-0 fs-3">Users</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header"><div class="card-title">Tambah User</div></div>

      <form method="post" action="{{ route('users.store') }}">
        @csrf
        <div class="card-body">
          @php
            $fields = [
              ['name', 'Nama', 'text'],
              ['email', 'Email', 'email'],
              ['password', 'Password', 'password'],
              ['address', 'Alamat', 'text'],
              ['phone_number', 'No. Hp.', 'text'],
              ['city', 'Kota', 'text'],
            ];
          @endphp

          @foreach ($fields as [$name, $label, $type])
          <div class="mb-3">
            <label for="{{ $name }}" class="form-label fw-bold">
              {{ $label }} <span class="text-danger">*</span>
            </label>
            <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
                   class="form-control @error($name) is-invalid @enderror"
                   value="{{ $type === 'password' ? '' : old($name) }}" required>
            @error($name)
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          @endforeach

          <div class="mb-3">
            <label for="roles" class="form-label fw-bold">Roles <span class="text-danger">*</span></label>
            <select id="roles" name="roles" class="form-select @error('roles') is-invalid @enderror" required>
              <option value="">Pilih</option>
              <option value="1" @selected(old('roles') == '1')>Admin</option>
              <option value="2" @selected(old('roles') == '2')>User</option>
            </select>
            @error('roles')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
