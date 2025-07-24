
<?php $__env->startSection('admin'); ?>
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="page-title">Update Video</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Video</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('video.update', $video->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-video-edit me-1"></i> Edit Video</h5>

                    <div class="row">
                        <!-- Title -->
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="<?php echo e($video->title); ?>" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        <?php echo e($video->category_id == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Video File -->
                        <div class="col-md-6 mb-3">
                            <label for="video" class="form-label">Replace Video (MP4)</label>
                            <input type="file" name="video" class="form-control" id="video" accept="video/mp4">
                            <small>Current: <?php echo e(basename($video->video)); ?></small>

                            
                            <?php $__errorArgs = ['video'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <?php if(Str::contains($message, 'greater than') || Str::contains($message, 'kilobytes')): ?>
                                    <small class="text-danger">Please upload a video file not more than 30MB.</small>
                                <?php else: ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php endif; ?>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Thumbnail -->
                        <div class="col-md-6 mb-3">
                            <label for="thumbnail" class="form-label">Replace Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" id="thumbnail" accept="image/*">
                            <small>Current: <?php echo e(basename($video->thumbnail)); ?></small>

                            <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <?php if(Str::contains($message, 'greater than') || Str::contains($message, 'kilobytes')): ?>
                                    <small class="text-danger">Please upload a thumbnail file not more than 1MB.</small>
                                <?php else: ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php endif; ?>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>


                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required><?php echo e($video->description); ?></textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/video/edit.blade.php ENDPATH**/ ?>