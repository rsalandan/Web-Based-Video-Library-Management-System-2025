@extends('backend.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit User</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div id="settings">
                            <form id="myForm" action="{{ route('user.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Important for PUT request -->

                                <h5 class="mb-4 text-uppercase">
                                    <i class="mdi mdi-account-circle me-1"></i> Update User
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select id="inputState" class="form-control" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male" @if ($user->gender == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female" @if ($user->gender == 'Female') selected @endif>
                                                    Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="join_date" class="form-label">Join Date</label>
                                            <input type="date" class="form-control" id="join_date" name="join_date"
                                                value="{{ old('join_date', isset($requestDetail) ? $requestDetail->join_date : '') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Role</label>
                                            <select class="form-control" name="role_id" required>
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="text" name="mobile" class="form-control"
                                                value="{{ $user->mobile }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input name="email" type="email" class="form-control"
                                                value="{{ $user->email }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label">New Password <small>(leave blank to
                                                        keep current)</small></label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Photo</label>
                                                <input name="photo" type="file" class="form-control"
                                                    accept="image/*">
                                                @if ($user->photo)
                                                    <img src="{{ asset($user->photo) }}" alt="User Photo" width="70"
                                                        class="mt-2">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
                                            <i class="mdi mdi-content-save"></i> Update
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    @endsection
