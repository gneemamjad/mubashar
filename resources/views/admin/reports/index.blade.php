@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.reports.list') }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.reports.create') }}" class="btn btn-primary">
                    {{ __('admin.reports.create') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select class="form-control" name="period">
                        <option value="">{{ __('admin.reports.period.custom') }}</option>
                        <option value="daily">{{ __('admin.reports.period.daily') }}</option>
                        <option value="weekly">{{ __('admin.reports.period.weekly') }}</option>
                        <option value="monthly">{{ __('admin.reports.period.monthly') }}</option>
                        <option value="yearly">{{ __('admin.reports.period.yearly') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="status">
                        <option value="">{{ __('admin.select_all') }}</option>
                        <option value="generated">{{ __('admin.reports.status.generated') }}</option>
                        <option value="pending">{{ __('admin.reports.status.pending') }}</option>
                        <option value="failed">{{ __('admin.reports.status.failed') }}</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('admin.title') }}</th>
                            <th>{{ __('admin.creation_date') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->title }}</td>
                            <td>{{ $report->created_at }}</td>
                            <td>{{ $report->status }}</td>
                            <td>
                                <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-info">
                                    {{ __('admin.show') }}
                                </a>
                                <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-sm btn-primary">
                                    {{ __('admin.edit') }}
                                </a>
                                <a href="{{ route('admin.reports.download', $report) }}" class="btn btn-sm btn-success">
                                    {{ __('admin.reports.download') }}
                                </a>
                                <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        {{ __('admin.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection 