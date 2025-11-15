@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.attributes.edit.title') }}</h3>
        </div>
        <form id="attribute-form">
            @csrf
            @method('PUT')
            <div class="card-body grid gap-5">
                <div class="w-full">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label flex items-center gap-1 max-w-56">
                            {{ __('admin.attributes.options.en_option_name') }}
                        </label>
                        <input class="input" type="text" id="key_en" name="key[en]"
                               value="{{ $attribute->getTranslation('key', 'en') }}" required dir="ltr"/>
                    </div>
                </div>
                <div class="w-full">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label flex items-center gap-1 max-w-56">
                            {{ __('admin.attributes.options.ar_option_name') }}
                        </label>
                        <input class="input" type="text" id="key_ar" name="key[ar]"
                               value="{{ $attribute->getTranslation('key', 'ar') }}" required dir="rtl"/>
                    </div>
                </div>
                <div class="flex items-center flex-wrap gap-2.5">
                    <label class="form-label max-w-56">
                        {{ __('admin.attributes.list_type') }}
                    </label>
                    <div class="grow">
                        <select class="select" id="list_type_id" name="list_type_id" required>
                            <option value="">{{ __('admin.attributes.select_list_type') }}</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ $attribute->list_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center flex-wrap gap-2.5">
                    <label class="form-label max-w-56">
                        {{ __('admin.attributes.input_type') }}
                    </label>
                    <div class="grow">
                        <select class="select" id="type" name="type" required>
                            <option value="" disabled>Select Input Type</option>
                            <option value="text" class="type-option type-1" {{ $attribute->type == 'text' ? 'selected' : '' }}>{{ __('admin.attributes.input_types.text') }}</option>
                            <option value="numeric" class="type-option type-1" {{ $attribute->type == 'numeric' ? 'selected' : '' }}>{{ __('admin.attributes.input_types.numeric') }}</option>
                            <option value="boolean" class="type-option type-1" {{ $attribute->type == 'boolean' ? 'selected' : '' }}>{{ __('admin.attributes.input_types.boolean') }}</option>
                            <option value="date" class="type-option type-1" {{ $attribute->type == 'date' ? 'selected' : '' }}>{{ __('admin.attributes.input_types.date') }}</option>
                            <option value="radio" class="type-option type-1" {{ $attribute->type == 'radio' ? 'selected' : '' }}>{{ __('admin.attributes.input_types.radio') }}</option>
                            <option value="dropdown" class="type-option type-2" {{ $attribute->type == 'dropdown' ? 'selected' : '' }}>{{ __('admin.attributes.input_types.dropdown') }}</option>
                            <option value="multiselect" class="type-option type-2" {{ $attribute->type == 'multiselect' ? 'selected' : '' }}>{{ __('admin.attributes.input_types.multiselect') }}</option>
                        </select>
                    </div>
                </div>

                <div id="options-container" style="display: {{ in_array($attribute->type, ['radio', 'multiselect', 'dropdown']) ? 'block' : 'none' }}" class="w-full">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label max-w-56">Options</label>
                        <div class="grow">
                            <div id="options-list" class="grid gap-4">
                                @foreach($attribute->attributeOptions as $index => $option)
                                    <div class="option-group border rounded-lg p-4 bg-gray-50">
                                        <div class="grid gap-3">
                                            <input type="hidden" name="options[{{ $index }}][id]" value="{{ $option->id }}">
                                            <div class="flex items-center gap-2">
                                                <input type="text" class="input grow" name="options[{{ $index }}][en]"
                                                    value="{{ $option->getTranslation('key', 'en') }}"
                                                    placeholder="{{ __('admin.attributes.options.en_option_name') }}" dir="ltr">
                                                <input type="text" class="input grow" name="options[{{ $index }}][ar]"
                                                    value="{{ $option->getTranslation('key', 'ar') }}"
                                                    placeholder="{{ __('admin.attributes.options.ar_option_name') }}" dir="rtl">
                                                <button type="button" class="btn btn-icon btn-danger remove-option">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary" id="add-option">
                                    <i class="fas fa-plus me-2"></i> Add Option
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
@endsection

@section('scripts')
<script>
$(function() {
    let optionCount = {{ $attribute->attributeOptions->count() }};

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
                    <input type="hidden" name="options[${optionCount}][id]" value="">
                    <div class="flex items-center gap-2">
                        <input type="text" class="input grow" name="options[${optionCount}][en]" placeholder="English Option" dir="ltr">
                        <input type="text" class="input grow" name="options[${optionCount}][ar]" placeholder="Arabic Option" dir="rtl">
                        <button type="button" class="btn btn-icon btn-danger remove-option">
                            <i class="fas fa-trash"></i>
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
            url: '{{ route("admin.attributes.update", $attribute->id) }}',
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
                alert('Error updating attribute: ' + xhr.responseJSON?.message || 'Unknown error');
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

        // Ensure the correct option is selected
        if (inputTypeSelect.value === '') {
            inputTypeSelect.value = inputTypeSelect.querySelector('option[selected]').value;
        }
    }

    listTypeSelect.addEventListener('change', function () {
        const selectedId = parseInt(this.value);
        if (!isNaN(selectedId)) {
            filterInputOptions(selectedId);
        }
    });

    // Trigger change event to filter input options on page load if needed
    const initialSelected = parseInt(listTypeSelect.value);
    if (!isNaN(initialSelected)) {
        filterInputOptions(initialSelected);
    }
});
</script>
@endsection
