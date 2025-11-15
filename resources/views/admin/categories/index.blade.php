@extends('layouts.main')

@section('content')
<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">
                    {{ __('categories.title') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('categories.manage_ads') }}
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card" style="margin:0 5% 5% 5%;">
            @if(auth()->guard('admin')->user()->hasAnyPermission(['create_admins'], 'admin'))
            <div class="d-flex justify-content-end">
                <button id="addCategoryBtn" type="button" class="btn btn-sm btn-primary" style="margin: 10px;">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ __('categories.add_category') }}
                </button>
            </div>
            @endif

            <div class="card-header py-5 flex-wrap gap-2">
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

            <div class="card-body">
                <div id="kt_tree_6"></div>
            </div>
        </div>
    </div>
</main>

<!-- Add/Edit Category Modal -->
<div class="modal fade open" id="categoryModal" tabindex="-1" style="z-index: 20; width: 50%; top: 25%; left: 25%; right: 25%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('categories.category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm">
                    <input type="hidden" id="categoryId">
                    <input type="hidden" id="parentId">

                    <!-- English Name -->
                    <div class="form-group mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="categoryName_en">
                            {{ __('categories.english_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" class="input" id="categoryName_en" name="name_en" required dir="ltr">
                    </div>

                    <!-- Arabic Name -->
                    <div class="form-group mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="categoryName_ar">
                            {{ __('categories.arabic_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" class="input" id="categoryName_ar" name="name_ar" required dir="rtl">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="margin: 10px">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('categories.close') }}
                </button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">
                    {{ __('categories.save') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Attribute Modal -->
<div class="modal fade open" id="attributeModal" tabindex="-1" style="z-index: 20; width: 50%; position: fixed; top: 25%; left: 25%;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ __('categories.manage_attributes') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="currentCategoryId">

                <div class="mb-4">
                    <label for="attributeTypeFilter" class="form-label">
                        {{ __('categories.filter_by_type') }}
                    </label>
                    <select class="form-select" id="attributeTypeFilter">
                        <option value="">{{ __('categories.all_types') }}</option>
                        @foreach(\App\Models\AttributeViewListType::all() as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="attributeSelect" class="form-label">
                        {{ __('categories.select_attribute') }}
                    </label>
                    <select class="form-select" id="attributeSelect">
                        <option value="">
                            {{ __('categories.select_attribute_placeholder') }}
                        </option>
                    </select>
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="enableFilter">
                    <label class="form-check-label" for="enableFilter">
                        {{ __('categories.enable_filter') }}
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('categories.close') }}
                </button>
                <button type="button" class="btn btn-primary" id="saveAttributesBtn">
                    {{ __('categories.save_changes') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <!-- Add this in the head section -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
            min-height: 300px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('scripts')
    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jsTree -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update modal calls to use Bootstrap 5 syntax
        const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
        const attributeModal = new bootstrap.Modal(document.getElementById('attributeModal'));
        let availableAttributes = [];
        let categoryAttributes = [];

        // Initialize jsTree
        $('#kt_tree_6').jstree({
            "core": {
                "themes": {
                    "responsive": false,
                    "variant": "large"
                },
                "multiple": false,
                "check_callback": function (operation, node, parent, position, more) {
                    if (operation === 'move_node') {
                        return parent.id !== '#'; // Prevent moving to root level
                    }
                    return true; // Allow all other operations
                },
                "data": {
                    "url": "{{ route('admin.categories.tree') }}",
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
                        items.Clone = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "{{ __('categories.menu_clone_category') }}",
                            "icon": "fa fa-copy text-info",
                            "action": function(obj) {
                                if (confirm('{{ __("categories.confirm_clone") }}')) {
                                    $.ajax({
                                        url: `{{ url('admin/categories') }}/${$node.id}/clone`,
                                        method: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            $('#kt_tree_6').jstree(true).refresh();
                                        },
                                        error: function() {
                                            alert('{{ __("categories.error_cloning") }}');
                                        }
                                    });
                                }
                            }
                        };
                        items.Create = {
                            "separator_before": false,
                            "separator_after": true,
                            "label": "{{ __('categories.menu_add_category') }}",
                            "icon": "fa fa-plus text-success",
                            "action": function(obj) {
                                $('#parentId').val($node.id);
                                categoryModal.show();
                            }
                        };
                        items.Edit = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "{{ __('categories.menu_edit') }}",
                            "icon": "fa fa-edit text-primary",
                            "action": function(obj) {
                                const node = $('#kt_tree_6').jstree(true).get_node(obj.reference);
                                $('#categoryId').val(node.id);
                                $('#categoryName_en').val(node.original.translations.en);
                                $('#categoryName_ar').val(node.original.translations.ar);
                                categoryModal.show();
                            }
                        };
                        items.Remove = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "{{ __('categories.menu_delete') }}",
                            "icon": "fa fa-trash text-danger",
                            "action": function(obj) {
                                if(confirm('{{ __("categories.confirm_delete") }}')) {
                                    deleteCategory($node.id);
                                }
                            }
                        };
                        items.AddAttribute = {
                            "separator_before": true,
                            "separator_after": false,
                            "label": "{{ __('categories.menu_add_attribute') }}",
                            "icon": "fa fa-plus text-success",
                            "action": function(obj) {
                                loadAvailableAttributes($node.id);
                            }
                        };
                    } else if ($node.type === 'attribute') {
                        items.EditFilter = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "{{ __('categories.menu_toggle_filter') }}",
                            "icon": "fa fa-filter text-primary",
                            "action": function(obj) {
                                const attributeId = $node.id.replace('attr_', '');
                                const categoryId = $node.parent.split('_')[1];
                                toggleAttributeFilter(categoryId, attributeId);
                            }
                        };
                        items.Remove = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "{{ __('categories.menu_remove_attribute') }}",
                            "icon": "fa fa-unlink text-danger",
                            "action": function(obj) {
                                if(confirm('{{ __("categories.confirm_remove_attribute") }}')) {
                                    const attributeId = $node.id.replace('attr_', '');
                                    const categoryId = $node.parent.split('_')[1];
                                    removeAttribute(categoryId, attributeId);
                                }
                            }
                        };
                    }

                    return items;
                }
            }
        }).on('move_node.jstree', function(e, data) {
            $.ajax({
                url: `{{ url('admin/categories') }}/${data.node.id}/move`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'POST',
                    parent_id: data.parent === '#' ? null : data.parent
                },
                success: function(response) {
                    $('#kt_tree_6').jstree(true).refresh();
                },
                error: function() {
                    alert('{{ __("categories.error_moving") }}');
                    $('#kt_tree_6').jstree(true).refresh();
                }
            });
        });

        // Add search functionality
        var searchTimeout = false;
        $('#category_search').keyup(function() {
            if(searchTimeout) { clearTimeout(searchTimeout); }
            searchTimeout = setTimeout(function() {
                $('#kt_tree_6').jstree(true).search($('#category_search').val());
            }, 250);
        });

        // Add Category Button
        $('#addCategoryBtn').click(function() {
            $('#categoryId').val('');
            $('#parentId').val('');
            $('#categoryName_en').val('');
            $('#categoryName_ar').val('');
            categoryModal.show();
        });

        // Save Category
        $('#saveCategoryBtn').click(function() {
            if($('#categoryName_en').val() == '' || $('#categoryName_ar').val() == '')
                return;

            const id = $('#categoryId').val();
            const data = {
                name_en: $('#categoryName_en').val(),
                name_ar: $('#categoryName_ar').val(),
                parent_id: $('#parentId').val() || null,
                _token: '{{ csrf_token() }}'
            };

            const url = id ?
                `{{ url('admin/categories') }}/${id}/update` :
                '{{ route('admin.categories.store') }}';

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    ...data,
                    _method: id ? 'POST' : 'POST'
                },
                success: function(response) {
                    categoryModal.hide();
                    $('#kt_tree_6').jstree(true).refresh();
                },
                error: function(xhr) {
                    alert('{{ __("categories.error_saving") }}' + xhr.responseJSON?.message || '{{ __("categories.error_unknown") }}');
                }
            });
        });

        function deleteCategory(id) {
            $.ajax({
                url: `{{ url('admin/categories/delete') }}/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $('#kt_tree_6').jstree(true).refresh();
                },
                error: function() {
                    alert('{{ __("categories.error_deleting") }}');
                }
            });
        }

        function loadCategoryAttributes(categoryId) {
            $('#currentCategoryId').val(categoryId);

            // Initialize Select2
            const $attributeSelect = $('#attributeSelect').select2({
                placeholder: 'Select attributes',
                allowClear: true,
                ajax: {
                    url: '{{ route("admin.attributes.list") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            type: $('#attributeTypeFilter').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(attr => ({
                                id: attr.id,
                                text: `${attr.key} (${attr.list_type_name})`,
                                list_type_id: attr.list_type_id
                            }))
                        };
                    },
                    cache: true
                }
            });

            // Load category's current attributes
            $.get(`{{ url('admin/categories') }}/${categoryId}/attributes`, function(data) {
                const formattedData = data.map(attr => ({
                    id: attr.id,
                    text: `${attr.key} (${attr.type_list.name})`,
                    selected: true
                }));

                $attributeSelect.empty().select2({
                    data: formattedData
                });
            });

            // Handle type filter changes
            $('#attributeTypeFilter').on('change', function() {
                $attributeSelect.val(null).trigger('change');
            });

            attributeModal.show();
        }

        // Update save attributes function
        $('#saveAttributesBtn').click(function() {
            const categoryId = $('#currentCategoryId').val();
            const attributeId = $('#attributeSelect').val();

            if (!attributeId) {
                alert('{{ __("categories.select_attribute_error") }}');
                return;
            }

            $.ajax({
                url: `{{ url('admin/categories') }}/${categoryId}/attributes`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    attributes: [attributeId],
                    enable_filter: $('#enableFilter').is(':checked')
                },
                success: function(response) {
                    attributeModal.hide();
                    $('#kt_tree_6').jstree(true).refresh();
                },
                error: function() {
                    alert('{{ __("categories.error_saving_attribute") }}');
                }
            });
        });

        function loadAvailableAttributes(categoryId) {
            $('#currentCategoryId').val(categoryId);
            $('#attributeSelect').empty().append('<option value="">Select an attribute...</option>');
            $('#enableFilter').prop('checked', false);

            // Load available attributes
            $.get('{{ route("admin.attributes.available", "") }}/' + categoryId, function(data) {
                data.forEach(attr => {
                    $('#attributeSelect').append(
                        `<option value="${attr.id}" data-type="${attr.list_type_id}">
                            ${attr.key} (${attr.list_type_name})
                        </option>`
                    );
                });
            });

            attributeModal.show();
        }

        // Update the type filter handler
        $('#attributeTypeFilter').on('change', function() {
            const selectedType = $(this).val();
            $('#attributeSelect option').each(function() {
                const $option = $(this);
                if (!selectedType || $option.val() === '' || $option.data('type') == selectedType) {
                    $option.show();
                } else {
                    $option.hide();
                }
            });
        });

        function toggleAttributeFilter(categoryId, attributeId) {
            $.ajax({
                url: `{{ url('admin/categories') }}/${categoryId}/attributes/${attributeId}/toggle-filter`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#kt_tree_6').jstree(true).refresh();
                },
                error: function() {
                    alert('Error toggling attribute filter');
                }
            });
        }

        function removeAttribute(categoryId, attributeId) {
            $.ajax({
                url: `{{ url('admin/categories') }}/${categoryId}/attributes/${attributeId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#kt_tree_6').jstree(true).refresh();
                },
                error: function() {
                    alert('{{ __("categories.error_removing_attribute") }}');
                }
            });
        }
    });
    </script>
@endsection
