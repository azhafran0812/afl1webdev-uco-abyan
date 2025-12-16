@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card" style="width: 500px;">
        <div class="card-header text-center">
            <h4>Register</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Daftar</button>
            </form>
            <div class="mt-3 text-center">
                Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
            </div>
        </div>
    </div>
</div>
@endsection
