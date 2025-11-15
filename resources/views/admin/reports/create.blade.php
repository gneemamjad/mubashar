@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.reports.create') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.reports.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">{{ __('admin.title') }}</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="period">{{ __('admin.reports.period.custom') }}</label>
                    <select name="period" id="period" class="form-control @error('period') is-invalid @enderror">
                        <option value="daily">{{ __('admin.reports.period.daily') }}</option>
                        <option value="weekly">{{ __('admin.reports.period.weekly') }}</option>
                        <option value="monthly">{{ __('admin.reports.period.monthly') }}</option>
                        <option value="yearly">{{ __('admin.reports.period.yearly') }}</option>
                    </select>
                    @error('period')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('admin.reports.generate') }}
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                        {{ __('admin.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 