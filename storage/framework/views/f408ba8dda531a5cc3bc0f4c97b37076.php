

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
                <h4 class="page-title">Role and Permission</h4>
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
          <form id="myForm" method="post" action="<?php echo e(route('role-permission.store')); ?>" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
  
              <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Role In Permission</h5>
  
              <div class="row"> 
  

  
         <div class="form-check mb-2 form-check-primary">
          <input class="form-check-input" type="checkbox" value="" id="customckeck15"  >
          <label class="form-check-label" for="customckeck15">Primary</label>
         </div>
   
          <hr>
  
          <?php $__currentLoopData = $permission_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="row">
              <div class="col-3">
  
                  <div class="form-check mb-2 form-check-primary">
          <input class="form-check-input" type="checkbox" value="" id="customckeck1"  >
          <label class="form-check-label" for="customckeck1"><?php echo e($group->group_name); ?></label>
         </div>
  
              </div>
  
              <div class="col-9">
  
      <?php
      $permissions = App\Models\User::getpermissionByGroupName($group->group_name);
      ?>            
  
          <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <div class="form-check mb-2 form-check-primary">
          <input class="form-check-input" type="checkbox" name="permission[]" value="<?php echo e($permission->id); ?>" id="customckeck<?php echo e($permission->id); ?>"  >
          <label class="form-check-label" for="customckeck<?php echo e($permission->id); ?>"><?php echo e($permission->name); ?></label>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <br>
  
              </div>
              
          </div> <!-- end row -->
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  
              </div> <!-- end row -->
   
              <div class="col-md-12">
          <div class="form-group mb-3">
              <label for="firstname" class="form-label">All Roles </label>
              <select name="role_id" class="form-select" id="example-select">
           <option selected disabled >Select Roles  </option>
           <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>          
          <option value="<?php echo e($role->id); ?>"> <?php echo e($role->name); ?></option> 
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
          </div>
      </div>
              
              <div class="text-end">
                  <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
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
                  $('input[type = checkbox]').prop('checked',true);
              }else{
                  $('input[type = checkbox]').prop('checked',false);
              } 
  
          });
     </script>
  
   
  
  
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/role-permission/create.blade.php ENDPATH**/ ?>