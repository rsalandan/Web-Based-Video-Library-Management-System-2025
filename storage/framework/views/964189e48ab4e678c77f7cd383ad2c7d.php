<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="<?php echo e(Auth::user()->photo ? asset(Auth::user()->photo) : asset('backend/assets/images/users/default.png')); ?>"
                    alt="User Photo" width="40" height="40"
                    style="cursor: zoom-in; border-radius: 50%; object-fit: cover;">
            </a>
            <div class="dropdown">

                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted"><?php echo e(Auth::user()->name); ?></p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Home</li>

                <li>
                    <a href="<?php echo e(url('/dashboard')); ?>">
                        <i data-feather="grid"></i>
                        <span> Dashboard </span>
                    </a>

                    <?php if(Auth::user()->can('video')): ?>
                <li>
                    <a href="<?php echo e(route('category.index')); ?>">
                        <i data-feather="tag"></i>
                        <span> Category </span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(Auth::user()->can('video')): ?>
                    <li>
                        <a href="<?php echo e(route('video.index')); ?>">
                            <i data-feather="video"></i>
                            <span> Video Library </span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(Auth::user()->can('user')): ?>
                    <li class="menu-title mt-2">Setting</li>
                    <li>
                        <a href="#sidebarAuth" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-key"></i>
                            <span> Manage User </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAuth">
                            <ul class="nav-second-level">
                                <?php if(Auth::user()->role_id != 5): ?>
                                    <li>
                                        <a href="<?php echo e(route('user.index')); ?>">Admin List</a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?php echo e(route('user.list')); ?>">User List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if(Auth::user()->can('permission')): ?>
                    <li>
                        <a href="<?php echo e(route('role-permission.index')); ?>">
                            <i data-feather="shield"></i>
                            <span> Role and Permission </span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>