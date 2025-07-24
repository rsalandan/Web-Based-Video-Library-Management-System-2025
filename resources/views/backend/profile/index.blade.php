@extends('backend.admin_dashboard')

@section('admin')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Profile</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!-- Profile Info Section (Left Side) -->
            <div class="col-lg-6 col-xl-4">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{ asset($adminData->photo) }}" alt="Product Photo" width="70" height="50"
                            style="cursor: zoom-in; border-radius: 50%;"
                            onclick="showImageModal('{{ asset($adminData->photo) }}')" />
                        <h4 class="mb-0">{{ $adminData->name }}</h4>
                        <p class="text-muted">{{ $adminData->email }}</p>

                        <div class="text-start mt-3">
                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span
                                    class="ms-2">{{ $adminData->name }}</span></p>
                                    class="ms-2">{{ $adminData->join_date }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>Role :</strong> <span
                                    class="ms-2">{{ $adminData->role->name }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>Mobile : </strong><span
                                    class="ms-2">{{ $adminData->mobile }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                    class="ms-2">{{ $adminData->email }}</span></p>
                        </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col-->

            <!-- Update Profile Form Section (Right Side) -->
            <div class="col-lg-6 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div id="settings">
                            <form id="myForm" action="{{ route('user.profile.update', $adminData->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Important for PUT request -->

                                <h5 class="mb-4 text-uppercase">
                                    <i class="mdi mdi-account-circle me-1"></i> Update Profile
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $adminData->name }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input name="email" type="email" class="form-control"
                                                value="{{ $adminData->email }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">New Password <small>(leave blank to
                                                    keep current)</small></label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="text" name="mobile" class="form-control"
                                                value="{{ $adminData->mobile }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input name="photo" type="file" class="form-control" accept="image/*">
                                            @if ($adminData->photo)
                                                <img src="{{ asset($adminData->photo) }}" alt="User Photo" width="70"
                                                    class="mt-2">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Role</label>
                                            <select class="form-control" name="role_id" required>
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $adminData->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mt-2">
                                        <i class="mdi mdi-content-save"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->

        </div> <!-- end row-->
    </div>
    <!-- end row-->

    <!-- jQuery for dynamic dropdown -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#department-select').on('change', function() {
            let departmentId = $(this).val();

            if (departmentId) {
                $.ajax({
                    url: "{{ route('get.designations') }}",
                    type: 'GET',
                    data: {
                        id: departmentId
                    },
                    success: function(data) {
                        $('#designation-select').empty().append(
                            '<option value="">Select Designation</option>');
                        $.each(data, function(key, value) {
                            $('#designation-select').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#designation-select').empty().append('<option value="">Select Designation</option>');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select',
                allowClear: true
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script>
        function showImageModal(src) {
            document.getElementById("modalImage").src = src;
            document.getElementById("imageModal").style.display = "block";
        }

        function closeImageModal() {
            document.getElementById("imageModal").style.display = "none";
        }
    </script>
@endsection
