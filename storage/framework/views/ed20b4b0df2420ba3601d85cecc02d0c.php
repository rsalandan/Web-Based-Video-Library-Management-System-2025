
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
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Category</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card text-center">
                </div> <!-- end card -->

            </div> <!-- end col-->

            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div id="settings">
                            <form id="myForm" action="<?php echo e(route('category.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <h5 class="mb-4 text-uppercase">
                                    <i class="mdi mdi-format-list-bulleted-type me-1"></i> Create Category
                                </h5>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Category Name" required>
                                        </div>

                                    </div> <!-- end row -->
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-content-save"></i>
                                            Save</button>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end col -->
    </div>
    <!-- end row-->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Name',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/category/create.blade.php ENDPATH**/ ?>