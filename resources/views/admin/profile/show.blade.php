@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                {{-- <span class="input-group-text"><i class="fas fa-envelope"></i></span> --}}
                                <input type="email" name="email" id="email" disabled class="input input-lg @error('email') is-invalid @enderror" 
                                    value="{{ old('email', auth()->guard('admin')->user()->email) }}"
                                    placeholder="Enter your email">
                            </div>
                            @error('email')
                                <span style="color: red" class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group mb-4 mt-5">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <div class="input-group">
                                {{-- <span class="input-group-text"><i class="fas fa-user"></i></span> --}}
                                <input type="text" name="name" id="name" class="input @error('name') is-invalid @enderror" 
                                    value="{{ old('name', auth()->guard('admin')->user()->name) }}"
                                    placeholder="Enter your name">
                            </div>
                            @error('name')
                                <span style="color: red" class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                      

                        <div class="form-group mb-4">
                            <label for="password" class="form-label fw-bold">New Password (Leave empty to keep current password)</label>
                            <div class="input-group">
                                {{-- <span class="input-group-text"><i class="fas fa-lock"></i></span> --}}
                                <input type="password" name="password" id="password" 
                                    class="input input-lg @error('password') is-invalid @enderror"
                                    placeholder="New password">
                            </div>
                            @error('password')
                                <span style="color: red" class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                            <div class="input-group">
                                {{-- <span class="input-group-text"><i class="fas fa-lock"></i></span> --}}
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="input input-lg"
                                    placeholder="Confirm your new password">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
