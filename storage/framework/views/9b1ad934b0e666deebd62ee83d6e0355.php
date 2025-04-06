<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/admin.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="<?php echo e(Request::is('admin/dashboard') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                </li>
                <li class="<?php echo e(Request::is('admin/users*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.users.index')); ?>">Users</a>
                </li>
                <li class="<?php echo e(Request::is('admin/products*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.products.index')); ?>">Products</a>
                </li>
                <li class="<?php echo e(Request::is('admin/orders*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.orders.index')); ?>">Orders</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <span>Toggle Menu</span>
                    </button>
                    <div class="ml-auto">
                        <a href="<?php echo e(route('logout')); ?>" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp_bumatay\htdocs\Perfume-Shop-main\resources\views/layouts/admin.blade.php ENDPATH**/ ?>