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
                            <li class="breadcrumb-item active">Admin</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Admin</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h6 class="header-title">All Admin</h6>
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <div class="d-flex justify-content-end gap-2 mb-4">
                                <a href="{{ url('/dashboard') }}" class="btn btn-info waves-effect waves-light"
                                    title="Dashboard">
                                    <i class="fe-skip-back"></i>
                                </a>
                                <a href="{{ route('user.create') }}" class="btn btn-blue waves-effect waves-light"
                                    title="Add">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>UserID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Join Date</th>
                                    <th>Role</th>
                                    <th>Email Address</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $key => $item)
                                    <!-- Corrected variable here -->
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($item->photo) }}" alt="User Photo" width="60"
                                                height="40" style="cursor: zoom-in; border-radius: 50%;"
                                                onclick="showImageModal('{{ asset($item->photo) }}')" />
                                        </td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gender }}</td>
                                        <td>
                                            {{ $item->join_date ? \Carbon\Carbon::parse($item->join_date)->format('M-d-Y') : '-' }}
                                        </td>
                                        <td>{{ $item->role->name ?? 'No Designation' }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>
                                            @if (auth()->user()->name === 'Admin' && $item->name !== 'Admin')
                                                <!-- Edit Button -->
                                                <a href="{{ route('user.edit', $item->id) }}"
                                                    class="btn btn-info waves-effect waves-light">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <button onclick="confirmDelete({{ $item->id }})"
                                                    class="btn btn-danger waves-effect waves-light">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>

                                                <!-- Hidden Delete Form -->
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('user.destroy', $item->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/user/index.js') }}"></script>
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
