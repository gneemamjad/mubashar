@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center min-h-screen mt-50" style="margin-top: 150px !important;">
        <div class="card max-w-[370px] w-full">
            <form action="{{ route('admin.login') }}" class="card-body flex flex-col gap-5 p-10" method="POST">
                @csrf
                <div class="text-center mb-2.5">
                    <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
                        {{ __('Admin Login') }}
                    </h3>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="form-label font-normal text-gray-900">
                        {{ __('Email Address') }}
                    </label>
                    <input class="input"
                        id="email"
                        name="email"
                        placeholder="admin@admin.com"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus />
                </div>

                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1">
                        <label class="form-label font-normal text-gray-900">
                            {{ __('Password') }}
                        </label>
                    </div>
                    <div class="input" data-toggle-password="true">
                        <input name="password"
                            placeholder="Enter Password"
                            type="password"
                            required
                            autocomplete="current-password" />
                        <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                            <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"></i>
                            <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"></i>
                        </button>
                    </div>
                </div>

                @if($errors->any())
                    <div class="error-message" style="color: #dc2626; font-size: 0.875rem; margin-top: -0.5rem; margin-left: 0.25rem;">
                        {{ $errors->first('error') }}
                    </div>
                @endif

                <label class="checkbox-group">
                    <input class="checkbox checkbox-sm"
                        name="remember"
                        id="remember"
                        type="checkbox"
                        {{ old('remember') ? 'checked' : '' }} />
                    <span class="checkbox-label">
                        {{ __('Remember Me') }}
                    </span>
                </label>

                <button class="btn btn-primary flex justify-center grow">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>
@endsection

<style>
.error-message {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: -0.5rem;
    margin-left: 0.25rem;
}
</style>
