@extends('layout')
@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit User</h3>
            </div>

            <form method="post" action="{{ route('users.update', $user['id']) }}">
              @csrf
              @method('PUT')
              <div class="card-body">

                @php
                  $fields = [
                    ['name', 'Nama', 'text'],
                    ['email', 'Email', 'email'],
                    ['password', 'Password', 'password'],
                    ['address', 'Alamat', 'text'],
                    ['house_number', 'Nomor Rumah', 'text'],
                    ['phone_number', 'No. Hp.', 'text'],
                    ['city', 'Kota', 'text'],
                  ];
                  $roleSekarang = strtoupper((string) old('roles', $user['roles'] ?? ''));
                @endphp

                @foreach ($fields as [$name, $label, $type])
                <div class="form-group">
                  <label for="{{ $name }}">{{ $label }} <span class="text-danger">*</span></label>
                  <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
                         class="form-control @error($name) is-invalid @enderror"
                         value="{{ $type === 'password' ? '' : old($name, $user[$name] ?? '') }}"
                         required>
                  @error($name)<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                @endforeach

                <div class="form-group">
                  <label for="roles">Roles <span class="text-danger">*</span></label>
                  <select class="custom-select @error('roles') is-invalid @enderror" name="roles" id="roles" required>
                    <option value=""> Pilih </option>
                    <option value="1" @selected(in_array($roleSekarang, ['1', 'ADMIN']))> Admin </option>
                    <option value="2" @selected(in_array($roleSekarang, ['2', 'USER']))> User </option>
                  </select>
                  @error('roles')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection