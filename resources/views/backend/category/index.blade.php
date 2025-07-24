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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Category</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Flex container for right-aligned button -->
                        <h6 class="header-title">All Category</h6>
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <div class="d-flex justify-content-end gap-2 mb-4">
                                <a href="{{ url('/dashboard') }}" class="btn btn-info waves-effect waves-light"
                                    title="Dashboard">
                                    <i class="fe-skip-back"></i>
                                    @if (Auth::user()->can('category.create'))
                                        <a href="{{ route('category.create') }}"
                                            class="btn btn-blue waves-effect waves-light" title="Add Category">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    @endif
                                </a>
                            </div>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    @if (Auth::user()->can('category.delete'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($category as $key => $item)
                                    <!-- Corrected variable here -->
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->status == '0')
                                                <span class="btn btn-warning btn-sm">Inactive</span>
                                            @elseif($item->status == '1')
                                                <span class="btn btn-success btn-sm">Active</span>
                                            @endif
                                        </td>
                                        @if (Auth::user()->can('category.delete'))
                                            <td>
                                                @if (Auth::user()->can('category.edit'))
                                                    <a href="{{ route('category.edit', $item->id) }}"
                                                        class='btn btn-info waves-effect waves-light' title="Edit"><i
                                                            class='far fa-edit'></i></a>
                                                @endif
                                                <!-- Delete Button -->
                                                @if (Auth::user()->can('category.delete'))
                                                    <button onclick="confirmDelete({{ $item->id }})"
                                                        class="btn btn-danger waves-effect waves-light" title="Delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                @endif

                                                <!-- Hidden Form for Delete Action -->
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('category.destroy', $item->id) }}" method="POST"
                                                    style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="text/javascript">
            function confirmDelete(id) {
                // Show SweetAlert confirmation prompt
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @endsection
