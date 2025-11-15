"use strict";
let lang = $('#lang').val();
const UsersModule = function () {
    var table;
    var datatable;

    // Handle search functionality
    var handleSearch = function() {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        if (!filterSearch) {
            console.error('Search input not found');
            return;
        }

        filterSearch.addEventListener('keyup', function(e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Initialize DataTable
    var initDatatable = function () {
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            dom:'<"top"r>',
            ajax: {
                url: "/admin/users/data",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function (xhr, error, thrown) {
                    console.error('DataTable Error:', error);
                }
            },
            columns: [
                { 
                    data: "first_name",
                    name: "first_name",
                    sortable: false,
                },
                { 
                    data: "last_name",
                    name: "last_name",
                    sortable: false,

                },
                { 
                    data: "user_name",
                    name: "user_name",
                    sortable: false,

                },
                { 
                    data: "app_version",
                    name: "app_version",
                    sortable: false,

                },
                { 
                    data: "email",
                    name: "email",
                    sortable: false,

                },
                { 
                    data: "currency",
                    name: "currency",
                    sortable: false,

                },
                { 
                    data: "created_at_formatted",
                    name: "created_at"
                },
                { 
                    data: "otp",
                    name: "otp",
                    sortable: false,

                },
                { 
                    data: "mobile",
                    name: "mobile",
                    sortable: false,

                },
                { 
                    data: "active",
                    name: "active",
                    sortable: false,

                    render: function(data) {
                        return `<div class="badge ${data ? 'badge-light-success' : 'badge-light-danger'}">
                            ${data ? 'Active' : 'Inactive'}
                        </div>`;
                    }
                },
                { 
                    data: "blocked",
                    name: "blocked",
                    sortable: false,

                    render: function(data) {
                        return `<div class="badge ${data ? 'badge-light-danger' : 'badge-light-success'}">
                            ${data ? 'Blocked' : 'Not Blocked'}
                        </div>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    sortable: false,

                    render: function (data, type, row) {
                        return `

                         ${canEditUsers ? `
                                   <div class="d-flex gap-2">
                                        <button type="button" 
                                            class="btn btn-sm ${row.blocked ? 'btn-light-success' : 'btn-light-danger'} toggle-block" 
                                            data-id="${row.id}"
                                            data-bs-toggle="tooltip" 
                                            title="${row.blocked ? 'Unblock' : 'Block'}">
                                            <i class="ki-filled ${row.blocked ? 'ki-check' : 'ki-pill'}"></i>
                                        </button>
                                    </div>
                                ` : ''}
                                    <div class="d-flex gap-2">
                                        <button type="button" 
                                            class="btn btn-sm show-user-adds" 
                                            data-id="${row.id}"
                                            title="">
                                            <i class="ki-filled ki-chart-line-star text-2xl link"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="/admin/users/${row.id}" 
                                            class="btn btn-sm">
                                            <i class="ki-filled ki-pin text-2xl"></i>
                                        </a>
                                    </div>
                                `;
                    }
                }
            ],
            order: [[6, 'desc']],
            pageLength: 10,
            "drawCallback": function(settings) {
                // Update pagination info
                let info = datatable.page.info();
                let paginationHtml = createCustomPagination(info);
                
                let html = `
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="fs-10" id="custom-pagination">
                            ${info.start + 1}-${info.end} of ${info.recordsTotal}  ${paginationHtml}
                        </div>
                    </div>`;
                
                $('.datatable-info').html(html);

                // Bind click events for pagination buttons
                $('#custom-pagination button[data-page]').on('click', function() {
                    const page = $(this).data('page');
                    let newPage = info.page;

                    if (page === 'prev') {
                        newPage = Math.max(0, info.page - 1);
                    } else if (page === 'next') {
                        newPage = Math.min(info.pages - 1, info.page + 1);
                    } else {
                        newPage = parseInt(page);
                    }

                    if (newPage !== info.page) {
                        datatable.page(newPage).draw('page');
                    }
                });
            }
        });

        // Handle delete user
        $(table).on('click', '.delete-user', function() {
            const userId = $(this).data('id');
            deleteUser(userId);
        });

        // Handle block/unblock user
        $(table).on('click', '.toggle-block', function() {
            const userId = $(this).data('id');
            toggleUserBlock(userId);
        });

        // Handle activate/deactivate user
        $(table).on('click', '.toggle-active', function() {
            const userId = $(this).data('id');
            toggleUserActive(userId);
        });
    }

     // Add length change event handler
     $('#datatable_length').on('change', function() {
        datatable.page.len($(this).val()).draw();
    });

    // Function to create custom pagination
    function createCustomPagination(info) {
        if (info.pages <= 1) return '';

        let paginationHtml = '';
        const currentPage = info.page;
        const totalPages = info.pages;
        let first_arrow_dir = "left";
        let second_arrow_dir = "right";
        if(lang == 'ar'){
            first_arrow_dir = "right";
            second_arrow_dir = "left";
        }
        // Add prev button
        paginationHtml += `
            <button class="btn btn-icon btn-sm border-0 btn-light-primary" 
                data-page="prev" ${currentPage <= 0 ? 'disabled' : ''}>
                <i class="ki-outline ki-black-`+first_arrow_dir+` fs-7"></i>
            </button>`;

        // First page
        paginationHtml += `
            <button class="btn btn-icon btn-sm border-0 btn-light-primary ${currentPage === 0 ? 'active' : ''}" 
                data-page="0">1</button>`;

        // Add ellipsis and middle pages
        if (currentPage > 2) {
            paginationHtml += '<span class="mx-2">...</span>';
        }

        for (let i = Math.max(1, currentPage - 1); i <= Math.min(totalPages - 2, currentPage + 1); i++) {
            if (i <= 0 || i >= totalPages - 1) continue;
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary ${i === currentPage ? 'active' : ''}" 
                    data-page="${i}">${i + 1}</button>`;
        }

        if (currentPage < totalPages - 3) {
            paginationHtml += '<span class="mx-2">...</span>';
        }

        // Last page
        if (totalPages > 1) {
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary ${currentPage === totalPages - 1 ? 'active' : ''}" 
                    data-page="${totalPages - 1}">${totalPages}</button>`;
        }

        // Next button
        paginationHtml += `
            <button class="btn btn-icon btn-sm border-0 btn-light-primary" 
                data-page="next" ${currentPage >= totalPages - 1 ? 'disabled' : ''}>
                <i class="ki-outline ki-black-`+second_arrow_dir+` fs-7"></i>
            </button>`;

        return paginationHtml;
    }

    // Handle user deletion
    var deleteUser = function(userId) {
        Swal.fire({
            text: "Are you sure you want to delete this user?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/users/${userId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        }).then(function() {
                            datatable.ajax.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            text: "An error occurred while deleting the user.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        });
                    }
                });
            }
        });
    }

    // Handle block/unblock user
    var toggleUserBlock = function(userId) {
        const button = $(`.toggle-block[data-id="${userId}"]`);
        const isBlocked = button.find('i').hasClass('ki-check');
        
        Swal.fire({
            text: `Are you sure you want to ${isBlocked ? 'unblock' : 'block'} this user?`,
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: `Yes, ${isBlocked ? 'unblock' : 'block'}!`,
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/users/${userId}/toggle-block`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        }).then(function() {
                            datatable.ajax.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            text: "An error occurred while updating user status.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        });
                    }
                });
            }
        });
    }

    // Handle activate/deactivate user
    var toggleUserActive = function(userId) {
        Swal.fire({
            text: "Are you sure you want to toggle active status for this user?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, proceed!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/users/${userId}/toggle-active`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        }).then(function() {
                            datatable.ajax.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            text: "An error occurred while updating active status.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        });
                    }
                });
            }
        });
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#users_table');
            
            if (!table) {
                console.error('Table element not found');
                return;
            }

            initDatatable();
            handleSearch();
        }
    }
}();

// On document ready
$(document).ready(function() {
    UsersModule.init();

    $(document).on('click','.show-user-adds',function(){
        let id = $(this).attr('data-id');
        window.location.href = `/admin/users/${id}/ads`;
    });
});
