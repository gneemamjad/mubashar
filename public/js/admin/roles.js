
document.addEventListener('DOMContentLoaded', function() {
    // Handle role deletion
    let lang = $('#lang').val();
    document.querySelectorAll('.delete-role').forEach(button => {
        button.addEventListener('click', function() {
            const roleId = this.getAttribute('data-role-id');
            
            Swal.fire({
                title: lang == 'ar' ? 'هل أنت متأكد؟' : 'Are you sure?',
                text: lang == 'ar' ? "لن تتمكن من التراجع عن هذا!" : "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: lang == 'ar' ? 'نعم، قم بالحذف!' : 'Yes, delete it!',
                cancelButtonText: lang == 'ar' ? 'لا، إلغاء!' : 'No, cancel!',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send delete request
                    fetch(`/admin/roles/${roleId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                lang == 'ar' ? 'تم الحذف!' : 'Deleted!',
                                lang == 'ar' ? 'تم حذف الدور بنجاح.' : 'Role has been deleted.',
                                'success'
                            ).then(() => {
                                // Reload the page or remove the element
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                lang == 'ar' ? 'حدث خطأ!' : 'Error!',
                                data.message || lang == 'ar' ? 'حدث خطأ!' : 'Something went wrong!',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            lang == 'ar' ? 'حدث خطأ!' : 'Error!',
                            lang == 'ar' ? 'حدث خطأ!' : 'Something went wrong!',
                            'error'
                        );
                    });
                }
            });
        });
    });
}); 