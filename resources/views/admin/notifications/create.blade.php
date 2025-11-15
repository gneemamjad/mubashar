@extends('layouts.main')

@section('content')

<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('admin.notifications.title') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('admin.notifications.add') }}
                </div>
            </div>
        </div>
    </div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.notifications.add') }}</h3>
        </div>
        <form id="notification-form">
            @csrf
            <div class="card-body grid gap-5">
                <div class="w-full">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label flex items-center gap-1 max-w-56 text-sm">{{ __('admin.notifications.title') }}</label>
                        <input class="input h-8 btn-sm text-sm" type="text" name="title" required/>
                    </div>
                </div>

                <div class="w-full">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label flex items-center gap-1 max-w-56 text-sm">{{ __('admin.notifications.body') }}</label>
                        <textarea class="textarea text-2sm text-gray-600 font-normal" rows="5" name="body" required ></textarea>
                    </div>
                </div>

                <div class="flex items-center flex-wrap gap-2.5">
                    <label class="form-label max-w-56 text-sm">{{ __('admin.notifications.type') }}</label>
                    <div class="grow">
                        <select class="select h-8 select-sm text-sm" name="type" id="type" required>
                            <option value="all">{{ __('admin.notifications.all_users') }}</option>
                            <option value="specific_users">{{ __('admin.notifications.specific_users') }}</option>
                        </select>
                    </div>
                </div>

                <div id="users-container" style="display: none;" class="w-full">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label max-w-56 text-sm">{{ __('admin.notifications.users') }}</label>
                        <div class="grow">
                            <select class="select2 select-sm select" name="user_ids[]" id="users_select" multiple="multiple" style="width: 100%;" data-ajax--url="{{ route('admin.users.search') }}">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2.5">
                    <button type="submit" class="btn btn-primary btn-sm">{{ __('admin.notifications.send') }}</button>
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
    // Initialize Select2
    $('#users_select').select2({
        placeholder: 'Search users by name or mobile',
        allowClear: true,
        theme: 'bootstrap-5',
        width: '50%',
        closeOnSelect: false,
        selectionCssClass: 'select2--small',
        dropdownCssClass: 'select2--small',
        minimumInputLength: 2,
        ajax: {
            url: '{{ route("admin.users.search") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    notify: true,
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data.data.map(function(user) {
                        return {
                            id: user.id,
                            text: user.fullName + ' (' + user.mobile + ')'
                        };
                    }),
                    pagination: {
                        more: data.next_page_url !== null
                    }
                };
            },
            cache: true
        },
        language: {
            inputTooShort: function() {
                return "Please enter 2 or more characters";
            },
            searching: function() {
                return "Searching...";
            },
            noResults: function() {
                return "No users found";
            }
        }
    });

    $('#type').change(function() {
        const isSpecificUsers = $(this).val() === 'specific_users';
        $('#users-container').toggle(isSpecificUsers);
        if (!isSpecificUsers) {
            $('#users_select').val(null).trigger('change');
        }
    });

    $('#notification-form').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: '{{ route("admin.notifications.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Notification has been sent successfully.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '{{ route("admin.notifications.index") }}';
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Something went wrong while sending the notification.',
                });
            }
        });
    });
});
</script>

<style>
/* Select2 Container */
.select2-container--bootstrap-5 {
    width: 100% !important;
}

/* Selection Box - Reduce overall height */
.select2-container--bootstrap-5 .select2-selection {
    min-height: 32px !important;
    padding: 0.15rem 0.35rem;
}

/* Selection Box */
.select2-container--bootstrap-5 .select2-selection {
    background-color: #ffffff;
    border: 1px solid #e4e6ef;
    border-radius: 0.475rem;
    padding: 0.25rem 0.5rem;
    transition: border-color 0.15s ease-in-out;
}

.select2-container--bootstrap-5 .select2-selection:focus {
    border-color: #a1a5b7;
    box-shadow: none;
}

/* Multiple Selection */
.select2-container--bootstrap-5 .select2-selection--multiple {
    padding: 0px 2px;
}

.select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered {
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
    margin: 0;
    padding: 0;
}

/* Selection Choice - Made much smaller */
.select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
    background-color: #f5f8fa;
    color: #7e8299;
    border: 1px solid #e4e6ef;
    border-radius: 3px;
    padding: 0px 4px;
    margin: 1px;
    font-size: 10px;
    display: flex;
    align-items: center;
    gap: 2px;
    line-height: 1.2;
    height: 18px;
}

/* Remove Button - Made smaller */
.select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
    font-size: 9px !important;
    margin-right: 0px;
    width: 12px !important;
    height: 12px !important;

    display: flex;
    align-items: center;
    justify-content: center;
}
.select2-selection__choice__display{
    font-size: 9px !important;
}
.select2-selection__choice__remove{
    padding: 0px !important;
}

.select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #009ef7;
    opacity: 1;
    background: none;
}

/* Dropdown */
.select2-container--bootstrap-5 .select2-dropdown {
    border: 1px solid #e4e6ef;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
    margin-top: 4px;
}

/* Search Box */
.select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
    border: 1px solid #e4e6ef;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 13px;
}

.select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
    border-color: #a1a5b7;
    box-shadow: none;
}

/* Options */
.select2-container--bootstrap-5 .select2-results__option {
    padding: 6px 12px;
    font-size: 13px;
    color: #3f4254;
}

.select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
    background-color: #f5f8fa;
    color: #009ef7;
}

.select2-container--bootstrap-5 .select2-results__option[aria-selected=true] {
    background-color: #f5f8fa;
    color: #009ef7;
}

/* Placeholder */
.select2-container--bootstrap-5 .select2-selection__placeholder {
    color: #a1a5b7;
    font-size: 13px;
}

/* Clear Button - Made smaller */
.select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__clear {
    margin: 0;
    font-size: 12px;
    height: 18px;
    display: flex;
    align-items: center;
}

.select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__clear:hover {
    color: #009ef7;
    opacity: 1;
}

/* Search Input in Multiple - Made smaller */
.select2-container--bootstrap-5 .select2-selection--multiple .select2-search--inline .select2-search__field {
    margin: 0;
    padding: 0 4px;
    font-size: 11px;
    min-height: 18px;
    height: 18px;
}

/* Disabled State */
.select2-container--bootstrap-5.select2-container--disabled .select2-selection {
    background-color: #f5f8fa;
    border-color: #e4e6ef;
}

.select2-container--bootstrap-5.select2-container--disabled .select2-selection--multiple .select2-selection__choice {
    background-color: #e9ecef;
    color: #7e8299;
}

/* Loading Spinner */
.select2-container--bootstrap-5.select2-container--loading::after {
    content: '';
    display: block;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid #e4e6ef;
    border-top-color: #009ef7;
    border-radius: 50%;
    animation: select2-spinner 0.6s linear infinite;
}

@keyframes select2-spinner {
    to {
        transform: rotate(360deg);
    }
}
</style>
@endsection
