
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
                        <li class="breadcrumb-item active">Role and Permission</li>
                    </ol>
                </div>
                <h4 class="page-title">Role and Permission</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="header-title">All Role and Permission</h6>

                    <!-- Button for adding permission -->
                    <div class="d-flex justify-content-end gap-2 mb-4">
                        <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-info waves-effect waves-light ">
                            <i class="fe-skip-back"></i>
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
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><?php echo e($item->name); ?></td>
                                
                                <td>
                                            <!-- Edit Button (you can replace href with actual edit route) -->
                                            <a href="<?php echo e(route('backend.role-permission.edit', $item->id)); ?>"
                                                class="btn btn-info waves-effect waves-light" title="Edit Permission">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="<?php echo e(route('permission.create')); ?>" class="btn btn-primary waves-effect waves-light"
                                            title="Add Permission">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <a href="<?php echo e(route('role.create')); ?>" class="btn btn-success waves-effect waves-light"
                                            title="Add Role">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <a href="<?php echo e(route('role-permission.create')); ?>" class="btn btn-blue waves-effect waves-light"
                                            title="Assign Role and Permission">
                                            <i class="fas fa-plus"></i>
                                        </a>
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
<!-- End Content-->

<script type="text/javascript">
    function confirmDelete(permissionId) {
        if (confirm("Are you sure you want to delete this permission?")) {
            document.getElementById('delete-form-' + permissionId).submit();
        }
    }
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/role-permission/index.blade.php ENDPATH**/ ?>