$(document).ready(function() {
    let lang = $('#lang').val();
    let plansTable = $('#plans_table').DataTable({
        processing: true,
        serverSide: true,
        dom:'<"top"r>',
        ajax: {
            url: '/admin/plans/list'
        },
        columns: [
            { data: 'title', name: 'title',orderable: false },
            { data: 'price', name: 'price',orderable: false },
            { data: 'duration_days', name: 'duration_days',orderable: false },
            { data: 'is_active', name: 'is_active',orderable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        "order" : "",
        "drawCallback": function(settings) {
            // Update pagination info
            let info = plansTable.page.info();
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
                    plansTable.page(newPage).draw('page');
                }
            });
        }
    });

        // Add length change event handler
        $('#datatable_length').on('change', function() {
            plansTable.page.len($(this).val()).draw();
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

        
    // Create Plan Form Submit
    $('#createPlanForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#create_plan_modal').modal('hide');
                plansTable.ajax.reload();
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
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

    // Edit Plan
    $(document).on('click', '.edit-plan', function() {
        let planId = $(this).data('plan-id');
        window.location.href = `/admin/plans/${planId}/edit`;
    });

    // Update Plan Form Submit
    $('#editPlanForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#edit_plan_modal').modal('hide');
                plansTable.ajax.reload();
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
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

    // Delete Plan
    $(document).on('click', '.delete-plan', function() {
        let planId = $(this).data('plan-id');
        Swal.fire({
            title: lang == 'ar' ? 'هل أنت متأكد؟' : 'Are you sure?',
            text: lang == 'ar' ? "لن تتمكن من التراجع عن هذا!" : "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: lang == 'ar' ? 'نعم، قم بالحذف!' : 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/plans/' + planId,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        plansTable.ajax.reload();
                        Swal.fire(
                            lang == 'ar' ? 'تم الحذف!' : 'Deleted!',
                            response.message,
                            'success'
                        );
                    },
                    error: function(xhr) {
                        Swal.fire(
                            lang == 'ar' ? 'حدث خطأ!' : 'Error!',
                            lang == 'ar' ? 'حدث خطأ!' : 'Something went wrong!',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
