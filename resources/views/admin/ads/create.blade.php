@extends('layouts.main')

@section('custom-styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
<style>
    #search-box {
        width: 220px;
        height: 40px;
        font-size: 14px;
        border-radius: 7px;
        left: unset !important;
        right: calc(50% - 110px) !important;
        top: 10px !important;
        padding: 10px;
    }
    #addUserModal {
        z-index: 1000000;
        width: 100%;
        align-items: center;
        display: none;
        justify-content: center;
    }
    #addUserModal .modal-dialog {
        width: 50%;
    }
    .show {
        opacity: 1;
        display: flex !important;
    }
    .select2-container--default .select2-selection--single {
        height: 100%;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-top: 5px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 7px;
    }

    .dark .select2-container--default .select2-selection--single {
        background-color: #1F212A !important;
    }
    
    .dark .select2-dropdown {
        background-color: #1F212A !important;
    }

    .dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #1F212A !important;
    }

    .dark .dropzone {
        background-color: #1F212A !important;
    }

    .dark .dropzone:hover  {
        background-color: #040405ff !important;
    }


    #static-attribute .select[multiple], .select[size]:not([size="1"]),
    #featured-attribute .select[multiple], .select[size]:not([size="1"]) {
        height: 80px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
<style>
    /* Custom Dropzone Styling */
    .dropzone {
        border: 2px dashed #4f46e5 !important;
        /* Blue border */
        background: #f8f9fa !important;
        /* Light gray background */
        border-radius: 12px !important;
        /* Rounded corners */
        padding: 20px !important;
        text-align: center;
        transition: all 0.3s ease-in-out;
    }

    .dropzone:hover {
        background: #eef2ff !important;
        /* Lighter blue on hover */
        border-color: #4338ca !important;
        /* Darker blue */
    }

    .dz-message {
        font-size: 18px;
        font-weight: 600;
        color: #374151;
        /* Dark gray text */
    }

    .dz-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: white;
    }

    .dz-remove {
        color: #ef4444 !important;
        /* Red remove button */
        font-weight: bold;
        cursor: pointer;
    }

    .dz-remove:hover {
        text-decoration: underline;
    }

    .hiddenSubmit {
        opacity: 0;
        transition: all 5ms;
    }
</style>
@endsection

@section('content')

<main class="grow content pt-5" id="content" role="content">
    <!-- <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">
                    {{ __('admin.ads') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('ads.add') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
            </div>
        </div>
    </div> -->
    <!-- End of Container -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    {{ __('admin.ads') }} - {{ __('ads.add') }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row py-2">
                    <div class="col-md-6 mb-4">
                        <div class="card" style="height: 560px;">
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    Basic Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="w-full py-2">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                            Title
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <input class="input" id="name" name="name" placeholder="Enter Ad Title" type="text" required />
                                    </div>
                                </div>
                                <div class="w-full py-2">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5" style="flex-direction: column;align-items: stretch;">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                            Description
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <textarea class="textarea" id="description" name="description" placeholder="Text" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="input-group w-full py-2">
                                    <label class="form-label flex items-center gap-1 max-w-16">
                                        Price
                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>
                                    <input class="input" id="price" name="price" placeholder="Enter Price" type="text" />
                                    <div class="dropdown" data-dropdown="true" data-dropdown-trigger="click">
                                        <button class="dropdown-toggle btn btn-primary">
                                            <span id="selected-currency">Currency</span>
                                            <i class="ki-outline ki-down !text-sm dropdown-open:hidden"></i>
                                            <i class="ki-outline ki-up !text-sm hidden dropdown-open:block"></i>
                                        </button>
                                        <div class="dropdown-content w-full max-w-48 py-2" data-dropdown-dismiss="true">
                                            <div class="menu menu-default flex flex-col w-full">
                                                <span class="menu-item">
                                                    <a class="menu-link select-currency">
                                                        <span class="menu-title">SYP</span>
                                                    </a>
                                                </span>
                                                <span class="menu-item">
                                                    <a class="menu-link select-currency">
                                                        <span class="menu-title">USD</span>
                                                    </a>
                                                </span>
                                                <span class="menu-item">
                                                    <a class="menu-link select-currency">
                                                        <span class="menu-title">AED</span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full py-2" style="display: flex;gap: 10px;">
                                    <select class="select" name="user" id="user">
                                        <option value="">Select Owner</option>
                                        @foreach($users as $usr)
                                            <option value="{{ $usr->id }}">{{ $usr->first_name }} {{ $usr->last_name }} - {{ $usr->mobile }}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                        Add New User
                                    </button>
                                </div>
                                <div class="w-full py-2" style="display: flex;gap: 10px;">
                                    <select class="select" name="city_id" id="city_id">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full py-2" style="display: flex;gap: 10px;">
                                    <select class="select" name="area_id" id="area_id">
                                        <option value="">Select Area</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card" style="height: 560px;">
                            <div class="d-flex justify-content-end">
                            </div>
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    {{ __('categories.title') }}
                                </h3>
                                <div class="flex gap-6">
                                    <div class="relative">
                                        <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute top-1/2 start-0 -translate-y-1/2 ms-3"></i>
                                        <input id="category_search" style="padding-right: 2rem;" class="input input-sm pl-8"
                                            placeholder="{{ __('categories.search_placeholder') }}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="height: 387px;overflow-y: auto;">
                                <div id="catTree"></div>
                                <input type="text" id="catId" style="display:none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="d-flex justify-content-end">
                            </div>
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    Static Attributes
                                </h3>
                            </div>
                            <div class="card-body" id="static-attribute">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="d-flex justify-content-end">
                            </div>
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    Featured Attributes
                                </h3>
                            </div>
                            <div class="card-body" id="featured-attribute">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="d-flex justify-content-end">
                            </div>
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    Location <span id="lat"></span> <span id="long"></span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <input id="search-box" type="text" placeholder="Search location...">
                                <div id="map" style="width: 100%;height: 300px;"></div>
                                <br>
                                <label>Latitude: <span id="latitude">33.5132</span></label>
                                <label>Longitude: <span id="longitude">36.2768</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="d-flex justify-content-end">
                            </div>
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    Media
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="flex justify-center items-center">
                                    <form class="dropzone w-full" id="my-dropzone"></form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer justify-center">
                <a class="btn btn-link" id="uploadBtn" style="visibility: hidden;">
                    Save
                </a>
                <a class="btn btn-link" id="save">
                    Save
                </a>
            </div>
        </div>
    </div>
</main>
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="w-full py-2">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label flex items-center gap-1 max-w-32">
                                First Name
                                <span class="text-danger">
                                    *
                                </span>
                            </label>
                            <input class="input" id="first_name" name="first_name" placeholder="Enter First Name" type="text" required />
                        </div>
                    </div>
                    <div class="w-full py-2">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label flex items-center gap-1 max-w-32">
                                Last Name
                                <span class="text-danger">
                                    *
                                </span>
                            </label>
                            <input class="input" id="last_name" name="last_name" placeholder="Enter Last Name" type="text" required />
                        </div>
                    </div>
                    <!-- <div class="w-full py-2">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label flex items-center gap-1 max-w-32">
                                Email
                                <span class="text-danger">
                                    *
                                </span>
                            </label>
                            <input class="input" id="email" name="email" placeholder="example@example.com" type="email" required />
                        </div>
                    </div> -->
                    <div class="w-full py-2">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label flex items-center gap-1 max-w-32">
                                Mobile
                                <span class="text-danger">
                                    *
                                </span>
                            </label>
                            <input class="input" id="mobile" name="mobile" placeholder="09*******" type="text" required />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Save User</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('assets/js/pages/ads.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- <script src="https://cdn.tiny.cloud/1/uc6gub9t6bdk9wbufh8d74l0tc0ihkuz20e9tqufvojmve20/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script> -->
<script>
//   tinymce.init({
//     selector: '#description',
//     menubar: false,
//     plugins: 'lists',
//     toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist',
//     setup: function (editor) {
//       editor.on('keyup change', function () {
//         let content = editor.getContent({ format: 'text' }).trim();

//         if (content.length > 0) {
//           // Regex لاكتشاف الأحرف العربية
//           const arabicRegex = /[\u0600-\u06FF]/;

//           if (arabicRegex.test(content)) {
//             editor.getBody().setAttribute('dir', 'rtl');
//             editor.getBody().style.textAlign = 'right';
//           } else {
//             editor.getBody().setAttribute('dir', 'ltr');
//             editor.getBody().style.textAlign = 'left';
//           }
//         }
//       });
//     }
//   });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('#user').select2({
            placeholder: "Select an owner",
            allowClear: true,
            width: '100%',
            ajax: {
                url: '/admin/search-users',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // الكلمة التي يكتبها المستخدم
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (user) {
                            return {
                                id: user.id,
                                text: `${user.first_name} ${user.last_name} - ${user.mobile}`
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
        $('#city_id').select2({
            placeholder: "Select an city",
            allowClear: true,
            width: '100%'
        });
        $('#area_id').select2({
            placeholder: "Select an area",
            allowClear: true,
            width: '100%'
        });
        // Event listener for city change
        $('#city_id').on('change', function() {
            var cityId = $(this).val(); // Get selected city ID
            
            if (cityId) {
                // Make an AJAX call to get areas by city_id
                $.ajax({
                    url: '/admin/get-areas-by-city/' + cityId,
                    type: 'GET',
                    success: function(response) {
                        // Assuming response is an array of areas
                        var areaSelect = $('#area_id');
                        areaSelect.empty(); // Clear existing options
                        
                        // Add a default option
                        areaSelect.append('<option value="">Select an area</option>');
                        
                        // Populate the area dropdown with new options
                        response.data.forEach(function(area) {
                            areaSelect.append('<option value="' + area.id + '">' + area.name + '</option>');
                        });

                        // Re-initialize select2 after updating options
                        areaSelect.trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching areas:', error);
                    }
                });
            } else {
                // If no city is selected, clear the area dropdown
                $('#area_id').empty();
                $('#area_id').trigger('change');
            }
        });
        $(".select-currency").on("click", function () {
            let selectedCurrency = $(this).find(".menu-title").text();
            $("#selected-currency").text(selectedCurrency);
        });
        
        $('#catTree').jstree({
            "core": {
                "themes": {
                    "responsive": false,
                    "variant": "large"
                },
                "multiple": false,
                "check_callback": function(operation, node, parent, position, more) {
                    if (operation === 'move_node') {
                        return false; // Completely prevent moving nodes
                    }
                    return true; // Allow all other operations
                },
                "data": {
                    "url": "{{ route('admin.categories.catTree') }}",
                    "data": function(node) {
                        return {
                            "parent": node.id
                        };
                    },
                    "dataType": "json"
                },
                "animation": 300
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder text-warning"
                },
                "category": {
                    "icon": "fa fa-folder text-warning"
                },
                "attribute_folder": {
                    "icon": "fa fa-object-group text-info",
                    "valid_children": ["attribute"]
                },
                "attribute": {
                    "icon": "fa fa-tag text-success",
                    "valid_children": []
                }
            },
            'state': false,
            "plugins": [
                "contextmenu", "dnd", "search",
                "state", "types", "wholerow"
            ],
            "contextmenu": {
                "items": function($node) {
                    let items = {};

                    if ($node.type === 'category') {


                    }

                    return items;
                }
            }
        }).on('changed.jstree', function(e, data) {
            var i, j, r = [];
            for (i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).text);
            }
            let catId = 0;
            if (data.selected.length > 0) {
                catId = data.instance.get_node(data.selected[0]).id; 
            }
            $("#catId").val(catId);
            $.ajax({
                url: '/api/static-attributes/' + catId,
                type: 'GET',
                headers: {
                    'lang': '{{app()->getLocale()}}',
                    'Accept': 'application/json',
                    'version': '1.0.0'
                },
                success: function(response) {
                    let container = $('#static-attribute');
                    container.html('');
                    response.data.forEach(item => {
                        let inputElement = '';
                        if (item.id > 0) {

                            switch (item.type) {
                                case 'text':
                                    inputElement = `<input class="input" type="text" data-id="${item.id}" name="${item.title}" placeholder="${item.title}"  required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'date':
                                    inputElement = `<input class="input" type="date" data-id="${item.id}" name="${item.title}" placeholder="${item.title}"  required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'numeric':
                                    inputElement = `<input class="input" type="number" data-id="${item.id}" name="${item.title}" placeholder="${item.title}" required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'select':
                                    inputElement = `<select class="select" data-id="${item.id}" name="${item.title}" required="${item.required == '1' ? 'required' : ''}">
                                                    <option value="">Select ${item.title}</option>`;
                                    item.options.forEach(option => {
                                        inputElement += `<option value="${option.id}">${option.value}</option>`;
                                    });
                                    inputElement += `</select>`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;
                                case 'radio':
                                    inputElement = `<select class="select" data-id="${item.id}" name="${item.title}" required="${item.required == '1' ? 'required' : ''}">
                                                    <option value="">Select ${item.title}</option>`;
                                    item.options.forEach(option => {
                                        inputElement += `<option value="${option.id}">${option.value}</option>`;
                                    });
                                    inputElement += `</select>`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;
                                case 'dropdown':
                                    inputElement = `<select class="select" data-id="${item.id}" name="${item.title}" required="${item.required == '1' ? 'required' : ''}">
                                                    <option value="">Select ${item.title}</option>`;
                                    item.options.forEach(option => {
                                        inputElement += `<option value="${option.id}">${option.value}</option>`;
                                    });
                                    inputElement += `</select>`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'multiselect':
                                    inputElement = `<select class="select" data-id="${item.id}" name="${item.title}[]" multiple required="${item.required == '1' ? 'required' : ''}">
                                                    <option value="">Select ${item.title}</option>`;
                                    item.options.forEach(option => {
                                        inputElement += `<option value="${option.id}">${option.value}</option>`;
                                    });
                                    inputElement += `</select>`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'boolean':
                                    inputElement = `<input type="checkbox" data-id="${item.id}" name="${item.title}" value="1" ${item.required == '1' ? 'required' : ''}> ${item.title}`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-2.5">
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                default:
                                    inputElement = `<input class="input" data-id="${item.id}" type="text" name="${item.title}" placeholder="${item.title}"  required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                            }
                        }

                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            $.ajax({
                url: '/api/featured-attributes/' + catId,
                type: 'GET',
                headers: {
                    'lang': '{{app()->getLocale()}}',
                    'Accept': 'application/json',
                    'version': '1.0.0'
                },
                success: function(response) {
                    let container = $('#featured-attribute');
                    container.html('');
                    response.data.forEach(item => {
                        let inputElement = '';
                        if (item.id > 0) {

                            switch (item.type) {
                                case 'text':
                                    inputElement = `<input class="input" type="text" data-id="${item.id}" name="${item.title}" placeholder="${item.title}"  required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'date':
                                    inputElement = `<input class="input" type="date" data-id="${item.id}" name="${item.title}" placeholder="${item.title}"  required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'numeric':
                                    inputElement = `<input class="input" type="number" data-id="${item.id}" name="${item.title}" placeholder="${item.title}" required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'dropdown':
                                    inputElement = `<select class="select" data-id="${item.id}" name="${item.title}" required="${item.required == '1' ? 'required' : ''}">
                                                    <option value="">Select ${item.title}</option>`;
                                    item.options.forEach(option => {
                                        inputElement += `<option value="${option.id}">${option.value}</option>`;
                                    });
                                    inputElement += `</select>`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;
                                case 'multiselect':
                                    inputElement = `<select class="select" data-id="${item.id}" name="${item.title}[]" multiple required="${item.required == '1' ? 'required' : ''}">
                                                    <option value="">Select ${item.title}</option>`;
                                    item.options.forEach(option => {
                                        inputElement += `<option value="${option.id}">${option.value}</option>`;
                                    });
                                    inputElement += `</select>`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                case 'boolean':
                                    inputElement = `<input type="checkbox" data-id="${item.id}" name="${item.title}" value="1" ${item.required == '1' ? 'required' : ''}> ${item.title}`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-2.5">
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                                    break;

                                default:
                                    inputElement = `<input class="input" type="text" data-id="${item.id}" name="${item.title}" placeholder="${item.title}"  required="${item.required == '1' ? 'required' : ''}">`;
                                    container.append(`
                                    <div class="w-full py-2">
                                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                            <label class="form-label flex items-center gap-1 max-w-32">
                                                
                                            ${item.title}
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            ${inputElement}
                                        </div>
                                    </div>`);
                            }
                        }

                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            
        });


        var searchTimeout = false;
        function openParentsAndSearch(results) {
            const tree = $('#catTree').jstree(true);

            // استخراج كل المعرفات الفريدة للأبوية والعقد التي يجب فتحها
            let nodesToOpen = new Set();

            results.forEach(item => {
                item.parents.forEach(parentId => nodesToOpen.add(parentId));
                nodesToOpen.add(item.id);
            });

            nodesToOpen = Array.from(nodesToOpen);

            // دالة تفتح العقد واحد تلو الآخر
            function openNext(index) {
                if (index >= nodesToOpen.length) {
                    // بعد الفتح شغل البحث لتحديد العقد
                    tree.search($('#category_search').val());
                    return;
                }
                const nodeId = nodesToOpen[index];
                tree.open_node(nodeId, function() {
                    openNext(index + 1);
                });
            }

            openNext(0);
        }

        $('#category_search').keyup(function() {
            let query = $(this).val();

            if (query.length < 3) {
                $('#catTree').jstree(true).clear_search();
                return;
            }
            if (!query) {
                $('#catTree').jstree(true).clear_search();
                return;
            }

            $.ajax({
                url: "{{ route('admin.categories.searchCatTree') }}",
                data: { q: query },
                success: function(data) {
                    openParentsAndSearch(data);
                }
            });
        });

        $("#save").click(function(e) {
            e.preventDefault();
            $("#save").addClass('disabled');
            $("#save").addClass('hiddenSubmit');
            let title = $("#name").val();
            // let description = tinymce.get("description").getContent();
            let description = $("#description").val();
            let price = $("#price").val();
            let selectedUser = $("#user").val();
            let selectedCurrency = $("#selected-currency").text();
            let category = $("#catId").val();
            let area_id = $("#area_id").val();
            let city_id = $("#city_id").val();
            let latitude = $("#latitude").text().trim();
            let longitude = $("#longitude").text().trim();
            if(selectedCurrency == 'Currency') {
                Swal.fire({
                        text: "Error in add Add, The Currency is required",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    
                // Re-enable the button in case of error
                $("#save").removeClass('disabled');
                $("#save").removeClass('hiddenSubmit');

                return; // Stop the function
            }
            let staticAttributeData = {};
            let featuredAttributeData = {};

            $("#static-attribute input").each(function () {
                let name = $(this).attr("name");
                let id = $(this).data("id");
                let value;

                if ($(this).attr("type") === "checkbox") {
                    value = $(this).is(":checked") ? $(this).val() : "0"; // Checkbox value or default "0"
                } else {
                    value = $(this).val();
                }

                staticAttributeData[id] = value;
            });
            
            $("#static-attribute select").each(function () {
                let name = $(this).attr("name").replace("[]", ""); // Remove [] from name
                let id = $(this).data("id");
                let value = $(this).val() ? $(this).val() : []; // Get selected values or empty array

                staticAttributeData[id] = value;
            });

            $("#featured-attribute input").each(function () {
                let name = $(this).attr("name");
                let id = $(this).data("id");
                let value;

                if ($(this).attr("type") === "checkbox") {
                    value = $(this).is(":checked") ? $(this).val() : "0"; // Checkbox value or default "0"
                } else {
                    value = $(this).val();
                }

                featuredAttributeData[id] = value;
            });

            $("#featured-attribute select").each(function () {
                let name = $(this).attr("name").replace("[]", ""); // Remove [] from name
                let id = $(this).data("id");
                let value = $(this).val() ? $(this).val() : []; // Get selected values or empty array

                featuredAttributeData[id] = value;
            });

            $.ajax({
                url: '/admin/ads/store',
                type: 'POST',
                data: {
                  "title": title,
                  "description": description,
                  "price": price,
                  "selectedUser": selectedUser,
                  "selectedCurrency": selectedCurrency,
                  "category": category,
                  "staticAttributeData": staticAttributeData,
                  "featuredAttributeData": featuredAttributeData,
                  "latitude":latitude,
                  "longitude":longitude,
                  "area_id":area_id,
                  "city_id":city_id
                },
                headers: {
                    'lang': 'en',
                    'Accept': 'application/json',
                    'version': '1.0.0'
                },
                success: function(response) {
                    if(response.success && response.data && response.data.ad) {
                        window.adId = response.data.ad.id;
                        myDropzone.processQueue();
                    } else {
                        console.error('Unexpected response structure', response);
                    }
                },
                error: function(xhr, status, error) {
                        let errorMessage = "Unknown error occurred";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                    $("#save").removeClass('disabled');
                    $("#save").removeClass('hiddenSubmit');
                    Swal.fire({
                        text: errorMessage,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        
                    });
                }
            });
        })
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("#my-dropzone", {
        url: "/admin/ads/add-images", // Your API endpoint
        method: "POST",
        autoProcessQueue: false, // Prevent auto upload
        uploadMultiple: true, // Allow multiple files
        maxFilesize: 100, // Max file size (MB)
        acceptedFiles: "image/*,video/*", // Accept images & videos
        addRemoveLinks: true,
        dictDefaultMessage: "📂 Drag & Drop files here or click to upload",
        parallelUploads: 10, // Upload multiple files at once
        headers: {
            "lang": "en",
            "Accept": "application/json",
            "version": "1.0.0"
        },
        init: function() {
            var dropzone = this;
            document.addEventListener("DOMContentLoaded", function() {
                var uploadBtn = document.getElementById("uploadBtn");
                console.log(uploadBtn); // لازم يرجع العنصر
                uploadBtn.addEventListener("click", function() {
                    if (dropzone.getQueuedFiles().length > 0) {
                        alert("test2");
                        dropzone.processQueue();
                    } else {
                        Swal.fire({
                            text: "Ad has been successfully updated!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                    }
                });
            });
            // document.getElementById("uploadBtn").addEventListener("click", function() {
            //     if (dropzone.files.length > 0) {
            //         dropzone.processQueue();
            //     } else {
            //         alert("Please select at least one file to upload.");
            //     }
            // });

            this.on("sending", function(file, xhr, formData) {
                if (window.adId) {
                    formData.append("ad_id", window.adId);
                }
            });

            this.on("success", function(file, response) {
                console.log("Upload Successful:", response);
                Swal.fire({
                        text: "Add has been successfully created!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            location.href='/admin/ads';
                        }
                    });
                $("#save").removeClass('disabled');
                $("#save").removeClass('hiddenSubmit');
            });

            this.on("error", function(file, response) {
                console.error("Upload Error:", response);
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.users.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#user').append('<option value="'+response.user.id+'">'+response.user.first_name+' '+response.user.last_name+'</option>');
                        $('#user').val(response.user.id);
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        alert('User added successfully');
                    } else {
                        alert('Failed to add user');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmUBKuEtOb82IFN-XpmZTz7C4aBRKprKM&libraries=places&callback=initMap" async defer></script>
<script>
    function initMap() {
        var defaultLocation = {
            lat: 33.5132,
            lng: 36.2768
        };
        var map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 8
        });

        var marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });

        var input = document.getElementById('search-box');
        var searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    return;
                }
                marker.setPosition(place.geometry.location);
                updateLatLng(place.geometry.location);
                bounds.extend(place.geometry.location);
            });
            map.fitBounds(bounds);
        });

        google.maps.event.addListener(map, 'click', function(event) {
            var clickedLocation = event.latLng;
            marker.setPosition(clickedLocation);
            updateLatLng(clickedLocation);
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            updateLatLng(event.latLng);
        });

        function updateLatLng(location) {
            $('#latitude').html(location.lat());
            $('#longitude').html(location.lng());
        }
    }
</script>
@endsection