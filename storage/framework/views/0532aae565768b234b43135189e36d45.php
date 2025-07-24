

<?php $__env->startSection('admin'); ?>
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="page-title">Video Library</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Video Library</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Filter & Add -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <h6 class="header-title d-flex justify-content-between align-items-center">
                            Search Video
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-info btn-sm" title="Dashboard">
                                    <i class="fe-skip-back"></i>
                                </a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.create')): ?>
                                    <a href="<?php echo e(route('video.create')); ?>" class="btn btn-blue btn-sm" title="Add Video">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </h6>

                        <!-- Filter Form -->
                        <form action="<?php echo e(route('video.index')); ?>" method="GET" class="mt-3">
                            <div class="row g-2 align-items-end">

                                <!-- Category Filter -->
                                <div class="col-md-3">
                                    <select name="category_id" class="form-select form-select-sm">
                                        <option value="">-- Category --</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"
                                                <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Views Filter -->
                                <div class="col-md-3">
                                    <select name="views" class="form-select form-select-sm">
                                        <option value="">-- Views --</option>
                                        <option value="asc" <?php echo e(request('views') == 'asc' ? 'selected' : ''); ?>>Low to High
                                        </option>
                                        <option value="desc" <?php echo e(request('views') == 'desc' ? 'selected' : ''); ?>>High to
                                            Low</option>
                                    </select>
                                </div>

                                <!-- Likes Filter -->
                                <div class="col-md-3">
                                    <select name="likes" class="form-select form-select-sm">
                                        <option value="">-- Likes --</option>
                                        <option value="asc" <?php echo e(request('likes') == 'asc' ? 'selected' : ''); ?>>Low to High
                                        </option>
                                        <option value="desc" <?php echo e(request('likes') == 'desc' ? 'selected' : ''); ?>>High to
                                            Low</option>
                                    </select>
                                </div>

                                <!-- Rating Filter -->
                                <div class="col-md-3">
                                    <select name="rating" class="form-select form-select-sm">
                                        <option value="">-- Rating --</option>
                                        <option value="asc" <?php echo e(request('rating') == 'asc' ? 'selected' : ''); ?>>Low to
                                            High</option>
                                        <option value="desc" <?php echo e(request('rating') == 'desc' ? 'selected' : ''); ?>>High to
                                            Low</option>
                                    </select>
                                </div>

                                <!-- Buttons (Search/Reset) -->
                                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary px-3">Search</button>
                                    <a href="<?php echo e(route('video.index')); ?>" class="btn btn-sm btn-secondary px-3">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><br>

        <!-- View mode toggle buttons -->
        <div class="d-flex justify-content-end mb-3">
            <a href="<?php echo e(route('video.index', array_merge(request()->except('page'), ['view' => 'grid']))); ?>"
                class="btn btn-outline-primary me-2 <?php echo e($viewMode === 'grid' ? 'active' : ''); ?>">
                <i class="fas fa-th-large"></i> Grid
            </a>
            <a href="<?php echo e(route('video.index', array_merge(request()->except('page'), ['view' => 'list']))); ?>"
                class="btn btn-outline-primary <?php echo e($viewMode === 'list' ? 'active' : ''); ?>">
                <i class="fas fa-list"></i> List
            </a>
        </div>

        <?php if($viewMode === 'grid'): ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4 mt-2">
                <?php $__empty_1 = true; $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col d-flex">
                        <div class="card w-100 h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <!-- Video Preview -->
                                <a href="<?php echo e(route('video.show', $video->id)); ?>" class="position-relative d-inline-block"
                                    style="width: 100%; max-width: 100%;">
                                    <div class="ratio ratio-16x9 mb-2">
                                        <video id="video-<?php echo e($video->id); ?>" poster="<?php echo e(asset($video->thumbnail)); ?>"
                                            style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;"
                                            preload="metadata">
                                            <source src="<?php echo e(asset($video->video)); ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <i class="fas fa-play fa-3x position-absolute top-50 start-50 translate-middle text-white play-icon"
                                        title="Play Me!"></i>
                                </a>

                                <!-- Stats & Meta -->
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>
                                        <?php echo e(number_format($video->views ?? 0)); ?> views &middot;
                                        <?php echo e(number_format($video->likes_count ?? 0)); ?> likes &middot;
                                        <?php echo e($video->reviews_count ?? 0); ?> comments
                                    </span>
                                    <span><?php echo e($video->created_at->diffForHumans()); ?></span>
                                </div>

                                <p class="fw-semibold mb-1"><?php echo e($video->title); ?> || <?php echo e($video->category->name ?? 'N/A'); ?>

                                </p>

                                <p class="mb-2 small">
                                    <a href="<?php echo e(route('video.show', $video->id)); ?>"
                                        class="text-secondary text-decoration-none">
                                        <?php echo e(Str::limit($video->description, 60)); ?>...See more
                                    </a>
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                                    <div class="small">
                                        <strong>Avg Rating:</strong>
                                        <?php if(!empty($video->reviews_avg_rating) && $video->reviews_avg_rating > 0): ?>
                                            <span class="text-warning">
                                                <?php echo str_repeat('&#9733;', round($video->reviews_avg_rating)); ?>

                                            </span>
                                            (<?php echo e(number_format($video->reviews_avg_rating, 1)); ?>/5)
                                        <?php else: ?>
                                            No ratings yet
                                        <?php endif; ?>
                                    </div>

                                    <!-- Dropdown Actions -->
                                    <?php if(Auth::check() &&
                                            (Auth::id() === $video->user_id || Auth::user()->role_id == 1 || Auth::user()->can('video.create'))): ?>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-light dropdown-toggle p-1" href="#"
                                                role="button" id="videoDropdown-<?php echo e($video->id); ?>"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="videoDropdown-<?php echo e($video->id); ?>">
                                                <li>
                                                    <a href="<?php echo e(route('video.edit', $video->id)); ?>" class="dropdown-item">
                                                        <i class="far fa-edit me-1"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form id="delete-form-<?php echo e($video->id); ?>"
                                                        action="<?php echo e(route('video.destroy', $video->id)); ?>" method="POST"
                                                        class="m-0">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="button" class="dropdown-item text-danger"
                                                            onclick="confirmDelete(<?php echo e($video->id); ?>)">
                                                            <i class="far fa-trash-alt me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center">No videos found.</p>
                <?php endif; ?>
            </div>
        <?php elseif($viewMode === 'list'): ?>
            <div class="list-group mt-2">
                <?php $__empty_1 = true; $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="list-group-item list-group-item-action d-flex align-items-start gap-3">
                        <a href="<?php echo e(route('video.show', $video->id)); ?>">
                            <div class="mb-2" style="width: 300px; height: 120px; position: relative; cursor: pointer;"
                                onclick="window.location='<?php echo e(route('video.show', $video->id)); ?>'">
                                <video id="video-<?php echo e($video->id); ?>" poster="<?php echo e(asset($video->thumbnail)); ?>"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                                    <source src="<?php echo e(asset($video->video)); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <i class="fas fa-play fa-3x position-absolute top-50 start-50 translate-middle text-white play-icon"
                                    title="Play Me!"></i>
                            </div>
                        </a>
                        <div class="flex-grow-1">
                            <h5 class="mb-1"><?php echo e($video->title); ?> || <?php echo e($video->category->name ?? 'N/A'); ?></h5>
                            <p class="mb-1 text-truncate"> <a href="<?php echo e(route('video.show', $video->id)); ?>"
                                    class="text-secondary text-decoration-none">
                                    <?php echo e(Str::limit($video->description, 100)); ?>...See more
                                </a></p>
                            <small class="text-muted">
                                <?php echo e(number_format($video->views ?? 0)); ?> views &middot;
                                <?php echo e(number_format($video->likes_count ?? 0)); ?> likes &middot;
                                <?php echo e($video->reviews_count ?? 0); ?> comments &middot;
                                <?php echo e($video->created_at->diffForHumans()); ?>

                            </small>
                        </div>

                        <div class="d-flex flex-column justify-content-between align-items-end">
                            <div class="small mb-2">
                                <strong>Avg Rating:</strong><br>
                                <?php if(!empty($video->reviews_avg_rating) && $video->reviews_avg_rating > 0): ?>
                                    <span class="text-warning">
                                        <?php echo str_repeat('&#9733;', round($video->reviews_avg_rating)); ?>

                                    </span>
                                    (<?php echo e(number_format($video->reviews_avg_rating, 1)); ?>/5)
                                <?php else: ?>
                                    No ratings yet
                                <?php endif; ?>
                            </div>

                            <!-- Actions -->
                            <?php if(Auth::check() &&
                                    (Auth::id() === $video->user_id || Auth::user()->role_id == 1 || Auth::user()->can('video.create'))): ?>
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-light dropdown-toggle p-1" href="#" role="button"
                                        id="videoDropdownList-<?php echo e($video->id); ?>" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="videoDropdownList-<?php echo e($video->id); ?>">
                                        <li>
                                            <a href="<?php echo e(route('video.edit', $video->id)); ?>" class="dropdown-item">
                                                <i class="far fa-edit me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form id="delete-form-<?php echo e($video->id); ?>"
                                                action="<?php echo e(route('video.destroy', $video->id)); ?>" method="POST"
                                                class="m-0">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="dropdown-item text-danger"
                                                    onclick="confirmDelete(<?php echo e($video->id); ?>)">
                                                    <i class="far fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center">No videos found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($videos->appends(request()->except('page'))->links('pagination::bootstrap-5')); ?>

        </div>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the video permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>

        <style>
            .tiny-spacing {
                margin-top: 0.1rem !important;
                margin-bottom: 0 !important;
            }
        </style>

        <!-- Footer -->
        <div class="footer py-1 bg-light text-center mt-4">
            <div class="container">
                &copy; <?php echo e(date('Y')); ?> Your Company. All rights reserved.
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/video/index.blade.php ENDPATH**/ ?>