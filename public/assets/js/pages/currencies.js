$(document).ready(function() {

    let lang = $('#lang').val();

    $(document).on('click','.change-rate',function(){
        let rateId = $(this).attr('data-id');
        
        Swal.fire({
            title: lang == 'ar' ? 'ادخل سعر الصرف الجديد' : 'Enter New Exchange Rate',
            input: 'number',
            inputAttributes: {
                step: 'any',
                min: '0'
            },
            showCancelButton: true,
            confirmButtonText: lang == 'ar' ? 'تعديل' : 'Update',
            cancelButtonText: lang == 'ar' ? 'الغاء' : 'Cancel',

            showLoaderOnConfirm: true,
            preConfirm: (rate) => {
                if (!rate || rate <= 0) {
                    Swal.showValidationMessage(lang == 'ar' ? 'يرجى إدخال سعر صالح' : 'Please enter a valid rate');
                    return false;
                }
                return rate;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                updateCurrencyRate(rateId, result.value);
            }
        });
    })
});

// Add this function to handle rate updates
function updateCurrencyRate(rateId, newRate) {
    $.ajax({
        url: '/admin/currencies/update-rate',
        type: 'POST',
        data: {
            rateId: rateId,
            new_rate: newRate,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    // title: lang == 'ar' ? 'تم التعديل بنجاح' : 'Updated Successfully',
                    text: response.message
                });
                $('.rate-'+rateId).text(newRate)
                // Refresh the data table or update the specific row
                // $('#currencies-table').DataTable().ajax.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    // title: lang == 'ar' ? 'حدث خطأ' : 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                // title: lang == 'ar' ? 'حدث خطأ' : 'Error',
                text: lang == 'ar' ? 'فشل تعديل سعر العملة' : 'Failed to update currency rate'
            });
        }
    });
}