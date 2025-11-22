@extends('admin.layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card">
                <!-- Logo -->
                <div class="card-header pt-4 pb-4 text-center bg-primary">
                    <a href="#">
                        <span><img src="{{ asset('images/logo.png') }}" alt="" height="18"></span>
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Sign Up</h4>
                        <p class="text-muted mb-4">Create an account to access the admin panel.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input class="form-control" type="text" name="name" id="name" required
                                   placeholder="Enter your full name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input class="form-control" type="email" name="email" id="email" required
                                   placeholder="Enter your email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" required
                                       placeholder="Enter your password">
                                <div class="input-group-append" data-password="false">
                                    <div class="input-group-text">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" class="form-control"
                                   name="password_confirmation" required
                                   placeholder="Confirm your password">
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary" type="submit"> Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">Already have an account?
                        <a href="" class="text-muted ml-1"><b>Sign In</b></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
