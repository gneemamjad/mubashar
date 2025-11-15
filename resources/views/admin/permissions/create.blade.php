@extends('layouts.admin')

@section('content')
<div class="content px-5 py-5 lg:py-7">
    <div class="flex flex-wrap gap-5 mb-6">
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Create New Permission
        </h3>
    </div>

    <div class="card">
        <div class="card-body flex flex-col gap-5 p-6">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                
                <div class="flex flex-col gap-5 mb-5">
                    <div class="flex flex-col gap-2">
                        <label class="form-label font-medium text-gray-700 dark:text-gray-200">
                            Permission Name
                        </label>
                        <input type="text" 
                               class="input @error('name') is-invalid @enderror" 
                               placeholder="Enter permission name"
                               name="name"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-gray-500 text-sm">
                        <i class="ki-duotone ki-information-5 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        Permission names should be lowercase and use underscores (e.g. manage_users)
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="btn btn-light">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="btn btn-primary">
                        Create Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection