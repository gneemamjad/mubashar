"use strict";

// Modal toggle element
const modalEl = document.querySelector('#my_modal');

// Configuration options(optional)
const options = {
    backdropClass: 'transition-all duration-300 fixed inset-0 bg-gray-900 opacity-25',
    backdrop: true,
    disableScroll: true,
    persistent: true,
    modalClass: 'transition-all duration-300 fixed z-50' // Add z-index and transition
};

// Initialize object
const modal = new KTModal(modalEl, options);

// Show modal when button clicked
document.querySelector('[data-bs-target="#my_modal"]').addEventListener('click', function() {
    modal.show();
});

// Class definition
var AdminsList = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            lengthChange: false, // Hide length menu
            ajax: {
                url: '/admin/admins/data',
                type: 'POST',
                data: function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.active_only = $('input[name="active_only"]').is(':checked') ? 1 : 0;
                }
            },
            columns: [
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `<input type="checkbox" class="checkbox checkbox-sm" value="${data}">`;
                    }
                },
                {
                    data: null,
                    render: function (data) {
                        return `
                            <div class="flex items-center gap-2.5">
                                <div class="flex flex-col gap-0.5">
                                    <a href="/admin/admins/${data.id}/edit" class="leading-none font-medium text-sm text-gray-900 hover:text-primary">
                                        ${data.name}
                                    </a>
                                    <span class="text-2sm text-gray-700 font-normal">${data.email}</span>
                                </div>
                            </div>`;
                    }
                },
                {
                    data: 'role',
                    render: function (data) {
                        return `<span class="leading-none text-gray-800 font-normal">${data || 'No Role'}</span>`;
                    }
                },
                {
                    data: 'is_active',
                    render: function (data) {
                        const status = data ? 'Active' : 'Inactive';
                        const badgeClass = data ? 'success' : 'danger';
                        return `<span class="badge badge-sm badge-outline badge-${badgeClass}">${status}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `
                            <div class="menu" data-menu="true">
                                <div class="menu-item" data-menu-item-toggle="dropdown">
                                    <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                        <i class="ki-filled ki-dots-vertical"></i>
                                    </button>
                                    <div class="menu-dropdown menu-default w-full max-w-[175px]">
                                        ${canEditAdmins ? `
                                            <div class="menu-item">
                                                <a class="menu-link" href="/admin/admins/${data.id}/edit">
                                                    <span class="menu-icon">
                                                        <i class="ki-filled ki-pencil"></i>
                                                    </span>
                                                    <span class="menu-title">Edit</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <button class="menu-link w-full" onclick="AdminsList.toggleStatus(${data.id})">
                                                    <span class="menu-icon">
                                                        <i class="ki-filled ki-check"></i>
                                                    </span>
                                                    <span class="menu-title">Toggle Status</span>
                                                </button>
                                            </div>
                                        ` : ''}
                                        ${canDeleteAdmins ? `
                                            <div class="menu-separator"></div>
                                            <div class="menu-item">
                                                <button class="menu-link w-full" onclick="AdminsList.deleteAdmin(${data.id})">
                                                    <span class="menu-icon">
                                                        <i class="ki-filled ki-trash"></i>
                                                    </span>
                                                    <span class="menu-title">Remove</span>
                                                </button>
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>`;
                    }
                }
            ],
            drawCallback: function() {
                initializeMenus();
            }
        });
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#attributes-table');

            if (!table) {
                return;
            }

            initDatatable();

            // Handle status filter
            $('input[name="active_only"]').on('change', function() {
                datatable.ajax.reload();
            });

            // Handle search
            $('.input[placeholder="Search Admins"]').on('keyup', function() {
                datatable.search(this.value).draw();
            });
        },

        toggleStatus: function(id) {
            if (confirm('Are you sure you want to change this admin\'s status?')) {
                $.ajax({
                    url: `/admin/admins/${id}/toggle-status`,
                    type: 'PATCH',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        datatable.ajax.reload();
                        toastr.success('Admin status updated successfully');
                    },
                    error: function() {
                        toastr.error('Error updating admin status');
                    }
                });
            }
        },

        deleteAdmin: function(id) {
            if (confirm('Are you sure you want to delete this admin?')) {
                $.ajax({
                    url: `/admin/admins/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        datatable.ajax.reload();
                        toastr.success('Admin deleted successfully');
                    },
                    error: function() {
                        toastr.error('Error deleting admin');
                    }
                });
            }
        }
    }
}();



// On document ready
document.addEventListener('DOMContentLoaded', function() {
    AdminsList.init();
});
