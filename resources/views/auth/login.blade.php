@extends('layout.main')
@section('title', 'Login')
@section('content')
    <div class="row  justify-content-center">
        <div class="col-md-5 my-5">
            <div class="card">
                <div class="card-header">
                    Login :
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Success</strong> {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Failed</strong> {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login_auth') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="{{ old('email') }}" id="email"
                                class="form-control">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <br>
                        <button class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
