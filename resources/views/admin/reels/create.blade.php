@extends('layouts.main')

@section('custom-styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
<style>
    #search-box {
        width: 220px;
        height: 40px;
        font-size: 14px;
        border-radius: 7px;
        left: unset !important;
        right: calc(50% - 110px) !important;
        top: 10px !important;
        padding: 10px;
    }
    #addUserModal {
        z-index: 1000000;
        width: 100%;
        align-items: center;
        display: none;
        justify-content: center;
    }
    #addUserModal .modal-dialog {
        width: 50%;
    }
    .show {
        opacity: 1;
        display: flex !important;
    }
    .select2-container--default .select2-selection--single {
        height: 100%;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-top: 5px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 7px;
    }

    #static-attribute .select[multiple], .select[size]:not([size="1"]),
    #featured-attribute .select[multiple], .select[size]:not([size="1"]) {
        height: 80px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
<style>
    /* Custom Dropzone Styling */
    .dropzone {
        border: 2px dashed #4f46e5 !important;
        /* Blue border */
        background: #f8f9fa !important;
        /* Light gray background */
        border-radius: 12px !important;
        /* Rounded corners */
        padding: 20px !important;
        text-align: center;
        transition: all 0.3s ease-in-out;
    }

    .dark .dropzone {
        background-color: #1F212A !important;
    }

    .dark .dropzone:hover  {
        background-color: #040405ff !important;
    }

    .dropzone:hover {
        background: #eef2ff !important;
        /* Lighter blue on hover */
        border-color: #4338ca !important;
        /* Darker blue */
    }

    .dz-message {
        font-size: 18px;
        font-weight: 600;
        color: #374151;
        /* Dark gray text */
    }

    .dz-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: white;
    }

    .dz-remove {
        color: #ef4444 !important;
        /* Red remove button */
        font-weight: bold;
        cursor: pointer;
    }

    .dz-remove:hover {
        text-decoration: underline;
    }

    .hiddenSubmit {
        opacity: 0;
        transition: all 5ms;
    }

    
    .dark .select2-container--default .select2-selection--single {
        background-color: #1F212A !important;
    }
    
    .dark .select2-dropdown {
        background-color: #1F212A !important;
    }

    .dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #1F212A !important;
    }
</style>
@endsection

@section('content')

<main class="grow content pt-5" id="content" role="content">
    <!-- End of Container -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    {{ __('admin.reels') }} - {{ __('reels.add') }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row py-2">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    Basic Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="w-full py-2">
                                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                        <label class="form-label flex items-center gap-1 max-w-32">
                                            Description
                                            <span class="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <textarea class="textarea" id="description" name="description" placeholder="Text" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="w-full py-2">
                                    <select class="select" name="ad" id="ad">
                                        <option value="">Select Ad</option>
                                        @foreach($ads as $ad)
                                            <option value="{{ $ad->id }}" data-owner-id="{{$ad->user_id}}">{{ $ad->ad_number }} - {{ $ad->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full py-2" style="display: flex;gap: 10px;">
                                    <select class="select" name="user" id="user">
                                        <option value="">Select Owner</option>
                                        @foreach($users as $usr)
                                            <option value="{{ $usr->id }}">{{ $usr->first_name }} {{ $usr->last_name }} - {{ $usr->mobile }}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                        Add New User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="d-flex justify-content-end">
                            </div>
                            <div class="card-header py-2 flex-wrap gap-2">
                                <h3 class="card-title">
                                    Media
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="flex justify-center items-center">
                                    <form class="dropzone w-full" id="my-dropzone"></form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer justify-center">
                <a class="btn btn-link" id="uploadBtn" style="visibility: hidden;">
                    Save
                </a>
                <a class="btn btn-link" id="save">
                    Save
                </a>
            </div>
        </div>
    </div>
</main>
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="w-full py-2">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label flex items-center gap-1 max-w-32">
                                First Name
                                <span class="text-danger">
                                    *
                                </span>
                            </label>
                            <input class="input" id="first_name" name="first_name" placeholder="Enter First Name" type="text" required />
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
                            <input class="input" id="last_name" name="last_name" placeholder="Enter Last Name" type="text" required />
                        </div>
                    </div>
                    <!-- <div class="w-full py-2">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label flex items-center gap-1 max-w-32">
                                Email
                                <span class="text-danger">
                                    *
                                </span>
                            </label>
                            <input class="input" id="email" name="email" placeholder="example@example.com" type="email" required />
                        </div>
                    </div> -->
                    <div class="w-full py-2">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="form-label flex items-center gap-1 max-w-32">
                                Mobile
                                <span class="text-danger">
                                    *
                                </span>
                            </label>
                            <input class="input" id="mobile" name="mobile" placeholder="09*******" type="text" required />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Save User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Video Trim Modal -->
<div id="trimModal" style="display:none; position:fixed; top:0; left:0; 
    width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:9999; 
    justify-content:center; align-items:center;">
    <div style="background:white; padding:20px; width:600px; border-radius:8px;">
        <h3>Select the part you want (Max 1 minute)</h3>
        <video id="trimVideo" width="100%" controls></video>
        <br>
        <input type="range" id="startSlider" min="0" step="1" value="0">
        <p>Start Time: <span id="startTime">0</span>s</p>
        <div style="margin-top:10px; text-align:right;">
            <button id="confirmTrim" style="padding:5px 15px;">Trim & Upload</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://unpkg.com/@ffmpeg/ffmpeg@0.12.6/dist/ffmpeg.min.js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('assets/js/pages/ads.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#ad').select2({
            placeholder: "Select an ad",
            allowClear: true,
            width: '100%',
            ajax: {
                url: '/admin/search-ads',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term  
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (ad) {
                            return {
                                id: ad.id,
                                text: `${ad.ad_number} - ${ad.title}`
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
        $('#user').select2({
            placeholder: "Select an owner",
            allowClear: true,
            width: '100%',
            ajax: {
                url: '/admin/search-users',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // الكلمة التي يكتبها المستخدم
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (user) {
                            return {
                                id: user.id,
                                text: `${user.first_name} ${user.last_name} - ${user.mobile}`
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
        $('#ad').on('change', function() {
            let ownerId = $(this).find(':selected').data('owner-id'); // جلب الـ user_id من الخيار
            if (ownerId) {
                $('#user').val(ownerId).trigger('change'); // اختيار المستخدم المناسب
            } else {
                $('#user').val('').trigger('change'); // إفراغه إذا ما فيه قيمة
            }
        });
        $("#save").click(function(e) {
            e.preventDefault();
            $("#save").addClass('disabled');
            $("#save").addClass('hiddenSubmit');
            let description = $("#description").val();
            let selectedUser = $("#user").val();
            let selectedAd = $("#ad").val();

            $.ajax({
                url: '/admin/reels/store',
                type: 'POST',
                data: {
                  "description": description,
                  "selectedUser": selectedUser,
                  "selectedAd": selectedAd,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'lang': 'en',
                    'Accept': 'application/json',
                    'version': '1.0.0'
                },
                success: function(response) {
                    if(response.success && response.data && response.data.reel) {
                        window.reelId = response.data.reel.id;
                        myDropzone.processQueue();
                    } else {
                        console.error('Unexpected response structure', response);
                    }
                },
                error: function(xhr, status, error) {
                    $("#save").removeClass('disabled');
                    $("#save").removeClass('hiddenSubmit');
                    Swal.fire({
                        text: "Error in add Reel",
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
// const { createFFmpeg, fetchFile } = FFmpeg;

// const ffmpeg = createFFmpeg({ log: true });
</script>
<script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#my-dropzone", {
            url: "/admin/reels/add-reel", // Your API endpoint
            method: "POST",
            autoProcessQueue: false, // Prevent auto upload
            uploadMultiple: true, // Allow multiple files
            maxFilesize: 250, // Max file size (MB)
            acceptedFiles: "video/*", // Accept images & videos
            addRemoveLinks: true,
            dictDefaultMessage: "📂 Drag & Drop files here or click to upload",
            parallelUploads: 10, // Upload multiple files at once
            headers: {
                "lang": "en",
                "Accept": "application/json",
                "version": "1.0.0"
            },
            init: function() {
                var dropzone = this;

                document.getElementById("uploadBtn").addEventListener("click", function() {
                    if (dropzone.files.length > 0) {
                        dropzone.processQueue();
                    } else {
                        alert("Please select file to upload.");
                    }
                });

                this.on("sending", function(file, xhr, formData) {
                    if (window.reelId) {
                        formData.append("reel_id", window.reelId);
                    }
                });

                this.on("success", function(file, response) {
                    console.log("Upload Successful:", response);
                    Swal.fire({
                            text: "Reel has been successfully created!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                location.href='/admin/reels';
                            }
                        });
                    $("#save").removeClass('disabled');
                    $("#save").removeClass('hiddenSubmit');
                });

                this.on("error", function(file, response) {
                    console.error("Upload Error:", response);
                });
            }
        });
</script>

<script>
    $(document).ready(function() {
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.users.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#user').append('<option value="'+response.user.id+'">'+response.user.first_name+' '+response.user.last_name+'</option>');
                        $('#user').val(response.user.id);
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        alert('User added successfully');
                    } else {
                        alert('Failed to add user');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection