

<?php $__env->startSection('admin'); ?>

<?php use Illuminate\Support\Str; ?>

<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Role and Permission</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Role and Permission</h4>
            </div>
        </div>
    </div>

    <!-- Role & Permission Form -->
    <div class="row">
    

    <div class="col-lg-8 col-xl-12">
  <div class="card">
      <div class="card-body">
                                      
                                        
                                           
                                             
  
      <!-- end timeline content-->
  
      <div class="tab-pane" id="settings">
      
      <form id="myForm" method="POST" action="<?php echo e(route('backend.role.permission.update', $role->id)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="name" class="form-label">Roles Name</label>
                <!-- Hidden field to send the role name -->
                <input type="hidden" name="name" value="<?php echo e($role->name); ?>">
                <h3><?php echo e($role->name); ?></h3>
            </div>
        </div>
        <div class="form-check mb-2 form-check-primary">
            <input class="form-check-input" type="checkbox" value="" id="customckeck15">
            <label class="form-check-label" for="customckeck15">Primary</label>
        </div>
        <hr>

        <?php $__currentLoopData = $permission_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row">
                <div class="col-3">
                    <?php
                        $permissions = App\Models\User::getpermissionByGroupName($group->group_name);
                    ?>
                    <div class="form-check mb-2 form-check-primary">
                        <input class="form-check-input" type="checkbox" value="" id="customckeck1" <?php echo e(App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : ''); ?> >
                        <label class="form-check-label" for="customckeck1"><?php echo e($group->group_name); ?></label>
                    </div>
                </div>
                <div class="col-9">
                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check mb-2 form-check-primary">
                            <input class="form-check-input" type="checkbox" name="permission[]" <?php echo e($role->hasPermissionTo($permission->name) ? 'checked' : ''); ?> value="<?php echo e($permission->id); ?>" id="customckeck<?php echo e($permission->id); ?>">
                            <label class="form-check-label" for="customckeck<?php echo e($permission->id); ?>"><?php echo e($permission->name); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <br>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
            <i class="mdi mdi-content-save"></i> Save
        </button>
    </div>
</form>

      </div>
      <!-- end settings content-->
      
                                         
                                      </div>
                                  </div> <!-- end card-->
  
                              </div> <!-- end col -->
                          </div>
                          <!-- end row-->
  
                      </div> <!-- container -->
  
                  </div> <!-- content -->
  
  
                  <script type="text/javascript">
    $('#customckeck15').click(function(){
        if ($(this).is(':checked')) {
            $('input[type="checkbox"]').prop('checked', true);
        } else {
            $('input[type="checkbox"]').prop('checked', false);
        }
    });
</script>

  
   
  
  
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/role-permission/edit.blade.php ENDPATH**/ ?>