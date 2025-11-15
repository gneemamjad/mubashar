@extends('layouts.main')

@section('custom-styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css">

<!-- Custom CSS -->
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<main class="grow content pt-5" id="content" role="content">
    <!-- End of Container -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    {{ __('admin.sidebar.users') }} - {{ __('admin.edit') }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row py-2">
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="w-full py-2">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                            First Name
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <input class="input" id="first_name" name="first_name" placeholder="Enter First Name" type="text" value="{{$user->first_name}}" required />
                                    </div>
                                </div>
                                <div class="w-full py-2">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                            Last Name
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <input class="input" id="last_name" name="last_name" placeholder="Enter Last Name" type="text" value="{{$user->last_name}}" required />
                                    </div>
                                </div>
                                <div class="w-full py-2">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                            Email
                                        </label>
                                        <input class="input" id="email" name="email" placeholder="example@example.com" type="email" value="{{$user->email}}" />
                                    </div>
                                </div>
                                <div class="w-full py-2">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                            Mobile
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <input class="input" id="mobile" name="mobile" placeholder="09*******" type="text" value="{{$user->mobile}}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer justify-center">
                <a class="btn btn-link" id="save">
                    Save
                </a>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $("#save").click(function(e) {
            e.preventDefault();
            $("#save").addClass('disabled');
            let first_name = $("#first_name").val();
            let last_name = $("#last_name").val();
            let email = $("#email").val();
            let mobile = $("#mobile").val();



            let adUserId = @json($user->id);
            $.ajax({
                url: '/admin/users/'+adUserId,
                type: 'POST',
                data: {
                  "first_name": first_name,
                  "last_name": last_name,
                  "email": email,
                  "mobile": mobile
                },
                headers: {
                    'lang': 'en',
                    'Accept': 'application/json',
                    'version': '1.0.0'
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            text: "User has been successfully updated!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" }
                        }).then(function (result) {
                            location.href='/admin/users';
                        });
                    } else {
                        console.error('Unexpected response structure', response);
                    }
                },
                error: function(xhr, status, error) {
                    $("#save").removeClass('disabled');
                    Swal.fire({
                        text: "Error in update User",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        
                    });
                }
            });
        })
    });

</script>

@endsection