@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.reports.show') }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.reports.download', $report) }}" class="btn btn-success">
                    {{ __('admin.reports.download') }}
                </a>
                <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-primary">
                    {{ __('admin.edit') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>{{ __('admin.title') }}:</strong> {{ $report->title }}</p>
                    <p><strong>{{ __('admin.creation_date') }}:</strong> {{ $report->created_at }}</p>
                    <p><strong>{{ __('admin.status') }}:</strong> {{ $report->status }}</p>
                </div>
            </div>

            <div class="report-content mt-4">
                {!! $report->content !!}
            </div>
        </div>
    </div>
</div>
@endsection 