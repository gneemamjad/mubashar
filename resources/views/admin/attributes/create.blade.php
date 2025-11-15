@extends('layouts.main')

@section('content')
<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('admin.attributes.title') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('admin.attributes.add') }}
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.attributes.add') }}</h3>
        </div>
        <form id="attribute-form">
        <div class="card-body grid gap-5">

            <div class="w-full">
             <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
              <label class="form-label flex items-center gap-1 max-w-56 text-sm">
               {{ __('admin.attributes.en_name') }}
              </label>
              <input class="input input-sm" type="text" id="key_en" name="key[en]" required dir="ltr"/>
             </div>
            </div>
            <div class="w-full">
             <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
              <label class="form-label flex items-center gap-1 max-w-56 text-sm">
               {{ __('admin.attributes.ar_name') }}
              </label>
              <input class="input input-sm" type="text" id="key_ar" name="key[ar]" required dir="rtl"/>
             </div>
            </div>
            <div class="flex items-center flex-wrap gap-2.5">
             <label class="form-label max-w-56 text-sm">
                {{ __('admin.attributes.list_type') }}
             </label>
             <div class="grow">
              <select class="select select-sm" id="list_type_id" name="list_type_id" required>
                <option value="">{{ __('admin.attributes.select_list_type') }}</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
              </select>
             </div>
            </div>

            <div class="flex items-center flex-wrap gap-2.5">
                <label class="form-label max-w-56 text-sm">
                   {{ __('admin.attributes.input_type') }}
                </label>
                <div class="grow">
                    <select class="select select-sm" id="type" name="type" required>
                        <option value="" disabled selected>Select Input Type</option>
                        <option value="text" class="type-option type-1">{{ __('admin.attributes.input_types.text') }}</option>
                        <option value="numeric" class="type-option type-1">{{ __('admin.attributes.input_types.numeric') }}</option>
                        <option value="boolean" class="type-option type-1">{{ __('admin.attributes.input_types.boolean') }}</option>
                        <option value="date" class="type-option type-1">{{ __('admin.attributes.input_types.date') }}</option>
                        <option value="radio" class="type-option type-1">{{ __('admin.attributes.input_types.radio') }}</option>
                        <option value="dropdown" class="type-option type-2">{{ __('admin.attributes.input_types.dropdown') }}</option>
                        <option value="multiselect" class="type-option type-2">{{ __('admin.attributes.input_types.multiselect') }}</option>
                    </select>
                </div>
            </div>

            <div id="options-container" style="display: none;" class="w-full">
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">{{ __('admin.attributes.options_text') }}</label>
                    <div class="grow">
                        <div id="options-list" class="grid gap-4">
                            <div class="option-group border rounded-lg p-4 bg-gray-50">
                                <div class="grid gap-3">
                                    <div class="flex items-center gap-2">
                                        <input type="text" class="input grow input-sm" name="options[0][en]" placeholder="{{ __('admin.attributes.options.en_option_name') }}" dir="ltr">
                                        <input type="text" class="input grow input-sm" name="options[0][ar]" placeholder="{{ __('admin.attributes.options.ar_option_name') }}" dir="rtl">
                                        <button type="button" class="remove-option">
                                            <i class="ki-filled ki-trash fs-2 text-ls"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-primary" id="add-option">
                                <i class="fas fa-plus me-2"></i> {{ __('admin.attributes.options.add_option') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-2.5">
             <button type="submit" class="btn btn-primary">
              {{ __('admin.attributes.save') }}
             </button>
            </div>
        </div>
        </form>
    </div>
</div>
</main>
@endsection

@section('scripts')
<script>
$(function() {
    let optionCount = 1;

    // Show/hide options based on type
    $('#type').change(function() {
        if ($(this).val() === 'radio' || $(this).val() === 'multiselect' || $(this).val() === 'dropdown') {
            $('#options-container').show();
        } else {
            $('#options-container').hide();
        }
    });

    // Add option
    $('#add-option').click(function() {
        const newOption = `
            <div class="option-group border rounded-lg p-4 bg-gray-50">
                <div class="grid gap-3">
                    <div class="flex items-center gap-2">
                        <input type="text" class="input grow input-sm" name="options[${optionCount}][en]" placeholder="{{ __('admin.attributes.options.en_option_name') }}" dir="ltr">
                        <input type="text" class="input grow input-sm" name="options[${optionCount}][ar]" placeholder="{{ __('admin.attributes.options.ar_option_name') }}" dir="rtl">
                        <button type="button" class="remove-option">
                            <i class="ki-filled ki-trash fs-2 text-ls"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#options-list').append(newOption);
        optionCount++;
    });

    // Remove option
    $(document).on('click', '.remove-option', function() {
        $(this).closest('.option-group').remove();
    });

    // Form submission
    $('#attribute-form').submit(function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const options = [];

        // Collect options with translations
        $('[name^="options"]').each(function() {
            const name = $(this).attr('name');
            const matches = name.match(/options\[(\d+)\]\[([a-z]{2})\]/);
            if (matches) {
                const [, index, lang] = matches;
                if (!options[index]) options[index] = {};
                options[index][lang] = $(this).val();
            }
        });

        // Remove empty options
        const filteredOptions = options.filter(option => option && (option.en || option.ar));
        formData.delete('options');
        formData.append('options', JSON.stringify(filteredOptions));

        $.ajax({
            url: '{{ route("admin.attributes.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    window.location.href = '{{ route("admin.attributes.index") }}';
                }
            },
            error: function(xhr) {
                alert('Error saving attribute: ' + xhr.responseJSON?.message || 'Unknown error');
            }
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const listTypeSelect = document.getElementById('list_type_id');
        const inputTypeSelect = document.getElementById('type');

        function filterInputOptions(typeId) {
            // Show all options first
            const allOptions = inputTypeSelect.querySelectorAll('.type-option');
            allOptions.forEach(option => option.style.display = 'none'); // Hide all

            if (typeId == 1) {
                inputTypeSelect.querySelectorAll('.type-1').forEach(opt => opt.style.display = 'block');
            } else if (typeId == 2) {
                inputTypeSelect.querySelectorAll('.type-2').forEach(opt => opt.style.display = 'block');
            }

            // Reset selected value
            inputTypeSelect.value = '';
        }

        listTypeSelect.addEventListener('change', function () {
            const selectedId = parseInt(this.value);
            if (!isNaN(selectedId)) {
                filterInputOptions(selectedId);
            }
        });

        // Initialize if there's already a selected value (e.g., in edit mode)
        const initialSelected = parseInt(listTypeSelect.value);
        if (!isNaN(initialSelected)) {
            filterInputOptions(initialSelected);
        }
    });
</script>
@endsection
