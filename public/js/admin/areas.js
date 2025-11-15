$(document).ready(function() {
    let lang = $('#lang').val();

    const modalEl = document.querySelector('#addAreaModal');
    const modalEdit = document.querySelector('#editAreaModal');
    const options = {
        backdropClass: 'transition-all duration-300 fixed inset-0 bg-gray-900 opacity-25',
        backdrop: true,
        disableScroll: true,
        persistent: true,
        modalClass: 'transition-all duration-300 fixed z-50'
    };

    const modal = new KTModal(modalEl, options);
    const editModal = new KTModal(modalEdit, options);

    $(document).on('click','.addAreaModal',function(){
        modal.show();
    })
    // document.querySelector('[data-bs-target="#addAreaModal"]').addEventListener('click', function() {
    //     modal.show();
    // });

    $(document).on('click','.edit-area',function(){

        $("#area_id").val($(this).attr('data-id'))
        $("#name_en_edit").val($(this).data('en-name'))
        $("#name_ar_edit").val($(this).data('ar-name'))

        let active = $(this).data('active')
        let city = $(this).data('city')

        $("#city_edit").val(city).change();

        $('#is_active_edit').removeAttr('checked')
        if(active == 1){
            $('#is_active_edit').attr('checked',"true")
        }
        // let id = $(this).attr('data-id')
        // console.log($(this).data('ar-name'))
        // console.log($(this).attr('data-ar-name'))
        editModal.show();
    })

    var table = $('#areas-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/admin/areas-data",
        dom:'<"top"r>',
        orderable : false,
        columns: [
            // {data: 'id', name: 'id'},
            {data: 'name_en', name: 'name_en', orderable: false},
            {data: 'name_ar', name: 'name_ar', orderable: false},
            {data: 'city', name: 'city', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'actions', name: 'actions', orderable: false, searchable: false}
        ],
        "order" : "",
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

    $('#editAreaForm').submit(function(e) {
        e.preventDefault();
       
        let areaId = $('#editAreaModal input[name="area_id"]').val();
        let formData = {
            name_en: $('#editAreaModal input[name="name_en_edit"]').val(),
            name_ar: $('#editAreaModal input[name="name_ar_edit"]').val(),
            active: $('#editAreaModal input[name="is_active_edit"]').is(':checked'),
            city: $('#editAreaModal select[name="city_edit"]').val(),
            _token: $('input[name="_token"]').val(),
            _method: 'POST'
        };

        $.ajax({
            url: `/admin/areas/${areaId}/update`,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    editModal.hide();
                
                    // Show success message
                    Swal.fire({
                        text: lang == 'ar' ? "تم تحديث المنطقة بنجاح!" : "Area updated successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: lang == 'ar' ? "حسناً!" : "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    
                    // Reset the form
                    $('#editAreaForm')[0].reset();
                    
                    // Refresh the DataTable
                    $('#areas-table').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                  // Show success message
                  Swal.fire({
                    text: lang == 'ar' ? "يرجى التحقق من الحقول!" : "Error validation!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: lang == 'ar' ? "حسناً!" : "Ok, got it!",
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
            toastr.error(lang == 'ar' ? "هناك خطأ في تحديث الحالة!" : "Error updating status");
        });
    });

    $(document).on('click', '.delete-area', function() {
        var id = $(this).data('id');
        if (confirm(lang == 'ar' ? "هل أنت متاكد من حذف هذه المنطقة?" : "Are you sure you want to delete this city?")) {
            $.ajax({
                url: "/admin/areas/" + id+"/delete",
                type: 'POST',
                data: {_token: $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                     // Show success message
                     Swal.fire({
                        text: lang == 'ar' ? "تم حذف المنطقة بنجاح!" : "Area deleted successfully!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: lang == 'ar' ? "حسناً!" : "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                
                    table.ajax.reload();
                }
            });
        }
    });

    $('#saveArea').click(function() {
        let formData = {
            name_en: $('#name_en').val(),
            name_ar: $('#name_ar').val(),
            city: $('#city').val(),
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: '/admin/areas',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    modal.hide();
                
                    // Show success message
                    Swal.fire({
                        text: lang == 'ar' ? "تم إنشاء المنطقة بنجاح!" : "Area created successfully!",
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
                    $('#areas-table').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                Swal.fire({
                    text: lang == 'ar' ? "يرجى التحقق من الحقول!" : "Error validation!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: lang == 'ar' ? "حسناً!" : "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                });
            }
        });
    });

    $(document).on('click','.close-edit-modal',function(){
        editModal.hide();
    });

    $(document).on('click','.close-add-modal',function(){
        modal.hide();
    });
}); 
