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
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Role</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="header-title">All Role</h6>

                        <!-- Button for adding permission -->
                        <div class="d-flex justify-content-end gap-2 mb-4">
                            <a href="{{ url('/dashboard') }}" class="btn btn-info waves-effect waves-light">
                                <i class="fe-skip-back"></i>
                                <a href="{{ route('role.create') }}" class="btn btn-blue waves-effect waves-light"
                                    title="Add">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </a>
                        </div>

                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($roles as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <!-- Edit Button (you can replace href with actual edit route) -->
                                            <a href="{{ route('role.edit', $item->id) }}"
                                                class="btn btn-info waves-effect waves-light">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <!-- Delete Button with confirmation -->
                                            <button onclick="confirmDelete({{ $item->id }})"
                                                class="btn btn-danger waves-effect waves-light">
                                                <i class="far fa-trash-alt"></i>
                                            </button>

                                            <!-- Hidden Form for Delete Action -->
                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('role.destroy', $item->id) }}" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div>
    <!-- End Content-->
@endsection

<script type="text/javascript">
    function confirmDelete(permissionId) {
        if (confirm("Are you sure you want to delete this permission?")) {
            document.getElementById('delete-form-' + permissionId).submit();
        }
    }
</script>
