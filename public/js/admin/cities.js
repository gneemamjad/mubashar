$(document).ready(function() {
    let lang = $('#lang').val();
    const modalEl = document.querySelector('#addCityModal');
    const modalEdit = document.querySelector('#editCityModal');
    const options = {
        backdropClass: 'transition-all duration-300 fixed inset-0 bg-gray-900 opacity-25',
        backdrop: true,
        disableScroll: true,
        persistent: true,
        modalClass: 'transition-all duration-300 fixed z-50'
    };

    const modal = new KTModal(modalEl, options);
    const editModal = new KTModal(modalEdit, options);

    // const translations = {
    //     confirmDelete: Lang.get('admin.cities_areas.confirm_delete_city'),
    //     yesDelete: Lang.get('admin.cities_areas.yes_delete'),
    //     noCancel: Lang.get('admin.cities_areas.no_cancel'),
    //     deleted: Lang.get('admin.cities_areas.deleted_successfully'),
    //     error: Lang.get('admin.cities_areas.error_occurred'),
    //     statusUpdated: Lang.get('admin.cities_areas.status_updated'),
    // };

    $(document).on('click','.addCityModal',function(){
        modal.show();
    })

    $(document).on('click','.edit-city',function(){

        $("#city_id").val($(this).attr('data-id'))
        $("#name_en_edit").val($(this).data('en-name'))
        $("#name_ar_edit").val($(this).data('ar-name'))

        let active = $(this).data('active')

        $('#is_active_edit').removeAttr('checked')
        if(active == 1){
            $('#is_active_edit').attr('checked',"true")
        }
        // let id = $(this).attr('data-id')
        // console.log($(this).data('ar-name'))
        // console.log($(this).attr('data-ar-name'))
        editModal.show();
    })

    var table;
    if (!$.fn.DataTable.isDataTable('#cities-table')) {
        table = $('#cities-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/cities-data",
            dom:'<"top"r>',
            orderable: false,
            columns: [
                {data: 'name_en', name: 'name_en', orderable: false},
                {data: 'name_ar', name: 'name_ar', orderable: false},
                {data: 'status', name: 'status', orderable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "order": "",
            "drawCallback": function(settings) {
                // Update pagination info
                let info = table.page.info();
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
                        table.page(newPage).draw('page');
                    }
                });
            }
        });
    } else {
        table = $('#cities-table').DataTable();
    }

    $('#datatable_length').on('change', function() {
        table.page.len($(this).val()).draw();
    });

    const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
    if (filterSearch) {
        let searchTimeout;

        filterSearch.addEventListener('keyup', function(e) {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                const searchValue = e.target.value;
                table.search(searchValue).draw();
            }, 300);
        });

        filterSearch.addEventListener('search', function(e) {
            if (!this.value) {
                table.search('').draw();
            }
        });
    }
    
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

    $('#editCityForm').submit(function(e) {
        e.preventDefault();
       
        let cityId = $('#editCityModal input[name="city_id"]').val();
        let formData = {
            name_en: $('#editCityModal input[name="name_en_edit"]').val(),
            name_ar: $('#editCityModal input[name="name_ar_edit"]').val(),
            active: $('#editCityModal input[name="is_active_edit"]').is(':checked'),
            _token: $('input[name="_token"]').val(),
            _method: 'POST'
        };

        $.ajax({
            url: `/admin/cities/${cityId}/update`,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    editModal.hide();
                
                    // Show success message
                    Swal.fire({
                        text: "City updated successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    
                    // Reset the form
                    $('#editCityForm')[0].reset();
                    
                    // Refresh the DataTable
                    $('#cities-table').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                  // Show success message
                  Swal.fire({
                    text: "Error validation!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                });
            }
        });
    });

    $(document).on('change', '.toggle-status', function() {
        var url = $(this).data('url');
        $.post(url, {
            _token: $('meta[name="csrf-token"]').attr('content')
        }).fail(function() {
            toastr.error('Error updating status');
        });
    });

    $(document).on('click', '.delete-city', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this city?')) {
            $.ajax({
                url: "/admin/cities/" + id+"/delete",
                type: 'POST',
                data: {_token: $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                     // Show success message
                     Swal.fire({
                        text: "City deleted successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                
                    table.ajax.reload();
                }
            });
        }
    });

    $(document).on('click','.close-edit-modal',function(){
        editModal.hide();
    });

    $(document).on('click','.close-add-modal',function(){
        modal.hide();
    });

    $('#saveCity').click(function() {
        let formData = {
            name_en: $('#name_en').val(),
            name_ar: $('#name_ar').val(),
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: '/admin/cities',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    modal.hide();
                
                    // Show success message
                    Swal.fire({
                        text: lang == 'ar' ? "تم إنشاء المدينة بنجاح!" : "City created successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: lang == 'ar' ? "حسناً!" : "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    $('#name_ar').val("");
                    $("#name_en").val("");
                    // Refresh the DataTable
                    $('#cities-table').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                // Show success message
                Swal.fire({
                    text: lang == 'ar' ? "يرجى التحقق من الحقول!" : "Please check the fields!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: lang == 'ar' ? "حسناً!" : "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    });
}); 
