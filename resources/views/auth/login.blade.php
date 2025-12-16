@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card" style="width: 400px;">
        <div class="card-header text-center">
            <h4>Login</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="mt-3 text-center">
                Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a>
            </div>
        </div>
    </div>
</div>
@endsection
