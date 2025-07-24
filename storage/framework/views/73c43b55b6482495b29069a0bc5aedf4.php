
<?php $__env->startSection('admin'); ?>
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a></li>
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
                                <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-info waves-effect waves-light"
                                    title="Dashboard">
                                    <i class="fe-skip-back"></i>
                                </a>
                                <a href="<?php echo e(route('user.create')); ?>" class="btn btn-blue waves-effect waves-light"
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
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Corrected variable here -->
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <img src="<?php echo e(asset($item->photo)); ?>" alt="User Photo" width="60"
                                                height="40" style="cursor: zoom-in; border-radius: 50%;"
                                                onclick="showImageModal('<?php echo e(asset($item->photo)); ?>')" />
                                        </td>
                                        <td><?php echo e($item->code); ?></td>
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($item->gender); ?></td>
                                        <td>
                                            <?php echo e($item->join_date ? \Carbon\Carbon::parse($item->join_date)->format('M-d-Y') : '-'); ?>

                                        </td>
                                        <td><?php echo e($item->role->name ?? 'No Designation'); ?></td>
                                        <td><?php echo e($item->email); ?></td>
                                        <td><?php echo e($item->mobile); ?></td>
                                        <td>
                                            <?php if(auth()->user()->name === 'Admin' && $item->name !== 'Admin'): ?>
                                                <!-- Edit Button -->
                                                <a href="<?php echo e(route('user.edit', $item->id)); ?>"
                                                    class="btn btn-info waves-effect waves-light">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <button onclick="confirmDelete(<?php echo e($item->id); ?>)"
                                                    class="btn btn-danger waves-effect waves-light">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>

                                                <!-- Hidden Delete Form -->
                                                <form id="delete-form-<?php echo e($item->id); ?>"
                                                    action="<?php echo e(route('user.destroy', $item->id)); ?>" method="POST"
                                                    style="display: none;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('js/user/index.js')); ?>"></script>
    <script>
        function showImageModal(src) {
            document.getElementById("modalImage").src = src;
            document.getElementById("imageModal").style.display = "block";
        }

        function closeImageModal() {
            document.getElementById("imageModal").style.display = "none";
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/user/index.blade.php ENDPATH**/ ?>