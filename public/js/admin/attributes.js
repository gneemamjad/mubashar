"use strict";
let lang = $('#lang').val();
// Class definition
var KTAttributes = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'processing': true,
            'serverSide': true,
            dom:'<"top"r>',
            'ajax': {
                url: '/admin/attributes/data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            'columns': [
                {
                    data: 'key',
                    
                    orderable: false,
                    render: function(data, type, row) {
                        return `<div>EN: ${data.en}</div><div>AR: ${data.ar}</div>`;
                    }
                },
                { data: 'type', orderable: false, name: 'type' },
                { data: 'type_name', orderable: false, name: 'type_name' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            "order" : "",
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

   

    // Delete attribute
    var handleDeleteRows = () => {
        // Select all delete buttons
        table.addEventListener('click', function(e) {
            if (e.target.closest('.delete-attribute')) {
                const button = e.target.closest('.delete-attribute');
                const id = button.getAttribute('data-id');

                // Show confirmation dialog
                Swal.fire({
                    text: "Are you sure you want to delete this attribute???????",
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
                    console.log(result);
                    if (result.isConfirmed) {
                        // Delete attribute
                        $.ajax({
                            url: `/admin/attributes/${id}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Refresh datatable
                                datatable.ajax.reload();
                                console.log(response);
                                console.log("hi malek");
                                Swal.fire({
                                    text: "Attribute deleted successfully!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    text: "Error deleting attribute!",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    }

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


    // Public methods
    return {
        init: function () {
            table = document.querySelector('#attributes-table');

            if (!table) {
                return;
            }

            initDatatable();
            handleDeleteRows();
            handleSearch();
        }
    }
}();

// On document ready
document.addEventListener('DOMContentLoaded', function() {
    KTAttributes.init();
});
