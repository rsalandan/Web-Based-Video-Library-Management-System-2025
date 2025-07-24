
<?php $__env->startSection('admin'); ?>
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
                                <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-info waves-effect waves-light"
                                    title="Dashboard">
                                    <i class="fe-skip-back"></i>
                                    <?php if(Auth::user()->can('category.create')): ?>
                                        <a href="<?php echo e(route('category.create')); ?>"
                                            class="btn btn-blue waves-effect waves-light" title="Add Category">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <?php if(Auth::user()->can('category.delete')): ?>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Corrected variable here -->
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($item->name); ?></td>
                                        <td>
                                            <?php if($item->status == '0'): ?>
                                                <span class="btn btn-warning btn-sm">Inactive</span>
                                            <?php elseif($item->status == '1'): ?>
                                                <span class="btn btn-success btn-sm">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if(Auth::user()->can('category.delete')): ?>
                                            <td>
                                                <?php if(Auth::user()->can('category.edit')): ?>
                                                    <a href="<?php echo e(route('category.edit', $item->id)); ?>"
                                                        class='btn btn-info waves-effect waves-light' title="Edit"><i
                                                            class='far fa-edit'></i></a>
                                                <?php endif; ?>
                                                <!-- Delete Button -->
                                                <?php if(Auth::user()->can('category.delete')): ?>
                                                    <button onclick="confirmDelete(<?php echo e($item->id); ?>)"
                                                        class="btn btn-danger waves-effect waves-light" title="Delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <!-- Hidden Form for Delete Action -->
                                                <form id="delete-form-<?php echo e($item->id); ?>"
                                                    action="<?php echo e(route('category.destroy', $item->id)); ?>" method="POST"
                                                    style="display:none;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                </form>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/category/index.blade.php ENDPATH**/ ?>