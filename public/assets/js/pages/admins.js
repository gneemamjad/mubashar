"use strict";


// Modal toggle element
const modalEl = document.querySelector('#my_modal');
const editModalEl = document.querySelector('#edit_modal');
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
const editModal = new KTModal(editModalEl, options);
// Show modal when button clicked
document.querySelector('[data-bs-target="#my_modal"]').addEventListener('click', function() {
    modal.show();
});

$(document).on('click', '[data-bs-target="#edit_modal"]', function() {
    editModal.show();
});



// Hide modal when button clicked
document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function() {
    modal.hide();

    // Remove backdrop/gray screen after modal is hidden
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
});

// Hide modal when button clicked
document.querySelector('[data-bs-dismiss="c-modal"]').addEventListener('click', function() {
    modal.hide();

    // Remove backdrop/gray screen after modal is hidden
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
});

// Hide modal when button clicked
document.querySelector('[data-bs-dismiss="edit-modal"]').addEventListener('click', function() {
    editModal.hide();

    // Remove backdrop/gray screen after modal is hidden
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
});

// Hide modal when button clicked
document.querySelector('[data-bs-dismiss="c-edit-modal"]').addEventListener('click', function() {
    editModal.hide();

    // Remove backdrop/gray screen after modal is hidden
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
});
// Class definition
var KTAdmins = function () {
    // Shared variables
    var table;
    var datatable;
    var modalEl;
    var modal;
    var form;

    // Private functions
    var handleSearch = function() {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        if (!filterSearch) {
            console.error('Search input not found');
            return;
        }

        // Initialize debounce
        let searchTimeout;

        filterSearch.addEventListener('keyup', function(e) {
            // Clear previous timeout
            clearTimeout(searchTimeout);

            // Set new timeout for search
            searchTimeout = setTimeout(() => {
                const searchValue = e.target.value;
                console.log('Searching for:', searchValue); // Debug log
                datatable.search(searchValue).draw();
            }, 300); // 300ms delay
        });

        // Clear search on 'x' click
        filterSearch.addEventListener('search', function(e) {
            if (!this.value) {
                datatable.search('').draw();
            }
        });
    }

    var initDatatable = function () {
        // Initialize DataTable
        datatable = $(table).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "/admin/admins/data",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    // Simplify the search parameter
                    d.search_value = d.search.value; // This will be used in the controller
                    return d;
                },
                error: function (xhr, error, thrown) {
                    console.error('DataTable Error:', error);
                }
            },
            "columns": [
                { 
                    data: "name",
                    width: 150,
                    orderable: false,

                    render: function(data, type, row) {
                        return `                            
                            <div class="d-flex flex-column">
                                <a href="javascript:void(0)" class="text-gray-800 text-hover-primary mb-1 fs-5 fw-bold">${data}</a>
                            </div>
                        </div>`;
                    }
                },
                { data: "email" ,
                    sortable: false

                },
                { 
                    data: "role_name",
                    sortable: false,
                    render: function(data, type, row) {
                        return `<div class="badge badge-sm badge-light badge-outline">${data}</div>`;
                    }

                },
                { 
                    data: "status",
                    sortable: false,
                    render: function(data) {
                        let statusClasses = {
                            'active': 'badge-light-success',
                            'inactive': 'badge-light-warning',
                            'deleted': 'badge-light-danger'
                        }[data] || 'badge-light-primary';
                        
                        return `<div class="${statusClasses}">${data}</div>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="d-flex align-items-center gap-2">                               
                                ${canEditAdmins ? `
                                    <a href="javascript:void(0)" 
                                       class="btn btn-icon btn-sm btn-light-primary" 
                                       onclick="initializeEditModal(${row.id})">
                                        <i class="ki-filled ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                ` : ''}
                                ${canDeleteAdmins ? `
                                    <a href="javascript:void(0)" 
                                       class="btn btn-icon btn-sm btn-light-primary" 
                                       onclick="KTAdmins.deleteAdmin(${row.id})">
                                        <i class="ki-filled ki-trash fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </a>
                                ` : ''}
                            </div>
                        `;
                    }
                }
            ],
            "order": "",
            "pageLength": 10,
            dom:'<"top"r>',
            "language": {
                "lengthMenu": "Show _MENU_",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "paginate": {
                    "first": '<i class="ki-outline ki-double-left fs-7"></i>',
                    "last": '<i class="ki-outline ki-double-right fs-7"></i>',
                    "next": '<i class="ki-outline ki-black-right fs-7 rtl:transform rtl:rotate-180"></i>',
                    "previous": '<i class="ki-outline ki-black-left fs-7 rtl:transform rtl:rotate-180"></i>'
                }
            },
            "drawCallback": function(settings) {
                // Update pagination info and add pagination numbers inline
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

                // Initialize other components
                KTMenu.createInstances();
            }
        });

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
            
            // Add prev button
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary" 
                    data-page="prev" ${currentPage <= 0 ? 'disabled' : ''}>
                    <i class="ki-outline ki-black-left fs-7"></i>
                </button>`;

            // First page
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary ${currentPage === 0 ? 'active' : ''}" 
                    data-page="0">1</button>`;

            // Add ellipsis after first page if needed
            if (currentPage > 2) {
                paginationHtml += '<span class="mx-2">...</span>';
            }

            // Pages around current page
            for (let i = Math.max(1, currentPage - 1); i <= Math.min(totalPages - 2, currentPage + 1); i++) {
                if (i <= 0 || i >= totalPages - 1) continue;
                paginationHtml += `
                    <button class="btn btn-icon btn-sm border-0 btn-light-primary ${i === currentPage ? 'active' : ''}" 
                        data-page="${i}">${i + 1}</button>`;
            }

            // Add ellipsis before last page if needed
            if (currentPage < totalPages - 3) {
                paginationHtml += '<span class="mx-2">...</span>';
            }

            // Last page
            if (totalPages > 1) {
                paginationHtml += `
                    <button class="btn btn-icon btn-sm border-0 btn-light-primary ${currentPage === totalPages - 1 ? 'active' : ''}" 
                        data-page="${totalPages - 1}">${totalPages}</button>`;
            }

            // Add next button
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary" 
                    data-page="next" ${currentPage >= totalPages - 1 ? 'disabled' : ''}>
                    <i class="ki-outline ki-black-right fs-7"></i>
                </button>`;

            paginationHtml += '';

            return paginationHtml;
        }
    }

    // Handle form submission
    var handleForm = function() {
        // Get modal form
        form = document.querySelector('#createAdminForm');
        
        if (!form) {
            return;
        }

     
        // Submit button handler
        const submitButton = document.getElementById('createAdminSubmit');
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on');
            submitButton.disabled = true;

            // Submit form
            $.ajax({
                url: '/admin/admins',
                type: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    // Show success message
                    Swal.fire({
                        text: "Admin has been successfully created!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Reset form
                            form.reset();
                            modal.hide();
                            // Reload datatable
                            datatable.ajax.reload();
                        }
                    });
                },
                error: function(xhr) {
                    // Show error message
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                },
                complete: function() {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#admins_table');
            
            if (!table) {
                console.error('Table element not found');
                return;
            }

            // Initialize modal
            modalEl = document.querySelector('#my_modal');
            if (modalEl) {
                modal = new bootstrap.Modal(modalEl, {
                    keyboard: false,
                    backdrop: 'static'
                });
            } else {
                console.error('Modal element not found');
                return;
            }

            // Initialize form
            form = document.querySelector('#createAdminForm');
            if (!form) {
                console.error('Form element not found');
                return;
            }

            initDatatable();
            handleSearch();
            handleForm();
        },

        deleteAdmin: function(id) {
            Swal.fire({
                text: "Are you sure you want to delete this admin?",
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
                        url: `/admin/admins/delete/${id}`,
                        type: 'POST',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            Swal.fire({
                                text: "Admin has been deleted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function() {
                                // Reload datatable
                                datatable.ajax.reload();
                            });
                        }
                    });
                }
            });
        },

        createAdmin: function() {
            if (!modal) {
                console.error('Modal not initialized');
                return;
            }

            // Reset form
            if (form) {
                form.reset();
                // Remove any previous validation errors
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            }

            try {
                modal.show();
            } catch (e) {
                console.error('Error showing modal:', e);
            }
        }
    }
}();

// On document ready
$(document).ready(function() {
    KTAdmins.init();

    $('#createAdminForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Close the modal
                $('#my_modal').modal('hide');
                
                // Show success message
                Swal.fire({
                    text: "Admin created successfully!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                
                // Refresh the DataTable
                $('#admins_table').DataTable().ajax.reload();
                
                // Reset the form
                $('#createAdminForm')[0].reset();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                
                for (let field in errors) {
                    errorMessage += errors[field][0] + '\n';
                }
                
                Swal.fire({
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    });

   

    // Add edit form submission handler
    $('#editAdminForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitButton = form.find('button[type="submit"]');
        
        submitButton.attr('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                editModal.hide();
                
                Swal.fire({
                    text: "Admin updated successfully!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(function() {
                    // Reload the DataTable
                    $('#admins_table').DataTable().ajax.reload();
                });
            },
            error: function(xhr) {
                let errorMessage = "Something went wrong!";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            },
            complete: function() {
                submitButton.attr('disabled', false);
            }
        });
    });

    // Add modal close handler to reset form
    $('#edit_modal').on('hidden.bs.modal', function() {
        $('#editAdminForm')[0].reset();
    });
}); 


 // Add this function to handle edit modal population
 function initializeEditModal(adminId) {
    $.ajax({
        url: `/admin/admins/${adminId}/edit`,
        method: 'GET',
        success: function(response) {
            // Populate the edit form with the admin data
            const admin = response.admin;
            $('#edit_name').val(admin.name);
            $('#edit_email').val(admin.email);
            if(admin.roles.length > 0) {    
                $('#edit_role').val(admin.roles[0].id); // Assuming admin has one role
            }
            $('#edit_status').val(admin.is_active ? 1 : 0);
            // Update the form action URL
            $('#editAdminForm').attr('action', `/admin/admins/${adminId}`);
            
            // Show the modal
            editModal.show();
        },
        error: function(xhr) {
            Swal.fire({
                text: "Failed to load admin data",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    });
}