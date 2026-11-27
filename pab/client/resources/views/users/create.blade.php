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
            <li class="breadcrumb-item active">Tambah</li>
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
              <h3 class="card-title">Tambah User</h3>
            </div>

            @if ($errors->any())
              <div class="alert alert-danger m-3">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form class="form-valide" method="post" action="{{ route('users.store') }}">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Nama <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror"
                         name="name" id="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                  <label for="email">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror"
                         name="email" id="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                  <label for="password">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror"
                         name="password" id="password" required>
                </div>
                <div class="form-group">
                  <label for="address">Alamat <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('address') is-invalid @enderror"
                         name="address" id="address" value="{{ old('address') }}" required>
                </div>
                <div class="form-group">
                  <label for="house_number">Nomor Rumah <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('house_number') is-invalid @enderror"
                         name="house_number" id="house_number" value="{{ old('house_number') }}" required>
                </div>
                <div class="form-group">
                  <label for="phone_number">No. Hp. <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                         name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required>
                </div>
                <div class="form-group">
                  <label for="city">Kota <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('city') is-invalid @enderror"
                         name="city" id="city" value="{{ old('city') }}" required>
                </div>
                <div class="form-group">
                  <label for="roles">Roles <span class="text-danger">*</span></label>
                  <select class="custom-select @error('roles') is-invalid @enderror" name="roles" id="roles" required>
                    <option value="">Pilih</option>
                    <option value="ADMIN" @selected(old('roles') == 'ADMIN')>Admin</option>
                    <option value="USER" @selected(old('roles') == 'USER')>User</option>
                  </select>
                </div>
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>