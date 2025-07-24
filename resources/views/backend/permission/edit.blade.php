@extends('backend.admin_dashboard')
@section('admin')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Permission</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('permission.update', $permission->id) }}">
                        @csrf
                        @method('PUT')
                        <h5 class="mb-4 text-uppercase">
                            <i class="mdi mdi-pencil-circle me-1"></i> Edit Permission
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="group_name" class="form-label">Group</label>
                                    <input type="text" class="form-control @error('group_name') is-invalid @enderror"
                                        id="group_name" name="group_name"
                                        value="{{ old('group_name', $permission->group_name) }}" required>
                                    @error('group_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="mdi mdi-check-circle"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script type="text/javascript">
$(document).ready(function() {
    $('#editForm').validate({
        rules: {
            name: {
                required: true,
            },
            group_name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please enter the permission name',
            },
            group_name: {
                required: 'Please enter the group name',
            },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
    });
});
</script>