@extends('layouts.main')

@section('content')
<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('admin.plans.edit') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('admin.plans.edit') }}
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card" style="margin:0 5% 5% 5%;">
            <div class="card-body">
                <form id="editPlanForm" method="POST" action="{{ route('plans.update', ['plan' => $plan->id]) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- English Title -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="title_en">
                                {{ __('admin.plans.en_name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="input" id="title_en" name="title[en]" value="{{ $plan->getTranslation('title', 'en') }}" required>
                        </div>

                        <!-- Arabic Title -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="title_ar">
                                {{ __('admin.plans.ar_name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="input text-right" dir="rtl" id="title_ar" name="title[ar]" value="{{ $plan->getTranslation('title', 'ar') }}" required>
                        </div>
                    </div>

                    <!-- Description Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- English Description -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="description_en">
                                {{ __('admin.plans.en_description') }}
                            </label>
                            <textarea class="input" id="description_en" name="description[en]" rows="3">{{ $plan->getTranslation('description', 'en', '') }}</textarea>
                        </div>

                        <!-- Arabic Description -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="description_ar">
                                {{ __('admin.plans.ar_description') }}
                            </label>
                            <textarea class="input text-right" dir="rtl" id="description_ar" name="description[ar]" rows="3">{{ $plan->getTranslation('description', 'ar', '') }}</textarea>
                        </div>
                    </div>

                    <!-- Price Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="price">
                                {{ __('admin.plans.price') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" class="input" id="price" name="price" value="{{ $plan->price }}" required>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="old_price">
                                {{ __('admin.plans.old_price') }}
                            </label>
                            <input type="number" step="0.01" class="input" id="old_price" name="old_price" value="{{ $plan->old_price }}">
                        </div>
                    </div>

                    <!-- Duration Field -->
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="duration_days">
                            {{ __('admin.plans.duration_days') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" class="input" id="duration_days" name="duration_days" value="{{ $plan->duration_days }}" required>
                    </div>

                    <!-- Status Field -->
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="is_active">
                            {{ __('admin.plans.status') }} <span class="text-red-500">*</span>
                        </label>
                        <select class="input" id="is_active" name="is_active" required>
                            <option value="1" {{ $plan->is_active ? 'selected' : '' }}>{{ __('admin.plans.active') }}</option>
                            <option value="0" {{ !$plan->is_active ? 'selected' : '' }}>{{ __('admin.plans.inactive') }}</option>
                        </select>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <a href="{{ route('plans.index') }}" class="btn btn-ghost bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg transition duration-200">
                            {{ __('admin.plans.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg transition duration-200">
                            {{ __('admin.plans.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#editPlanForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
                }).then((result) => {
                    window.location.href = "{{ route('plans.index') }}";
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error'
                });
            }
        });
    });
});
</script>
@endsection
