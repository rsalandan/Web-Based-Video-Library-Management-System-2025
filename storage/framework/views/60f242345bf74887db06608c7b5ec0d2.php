<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Log In | VLMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="A fully featured admin theme for login" name="description" />
  <meta content="rSalandan" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo e(asset('backend/assets/images/favicon.ico')); ?>">

  <!-- Bootstrap css -->
  <link href="<?php echo e(asset('backend/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
  <!-- App css -->
  <link href="<?php echo e(asset('backend/assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" id="app-style" />
  <!-- Icons -->
  <link href="<?php echo e(asset('backend/assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
  <!-- Head JS (optional) -->
  <script src="<?php echo e(asset('backend/assets/js/head.js')); ?>"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      background-color: #2e3b4e;
      color: #dcdfe1;
      line-height: 1.6;
    }

    header {
      background-color: #1a252f;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    nav .logo h1 {
      font-size: 36px;
      margin: 0;
    }

    main {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80vh;
    }

    .signin-form {
      background-color: #34495e;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .signin-form h2 {
      font-size: 28px;
      color: #fff;
      margin-bottom: 15px;
    }

    .form-field {
      width: 100%;
      margin-bottom: 20px;
    }

    .form-field input {
      width: 100%;
      padding: 10px;
      border: 2px solid #bdc3c7;
      border-radius: 5px;
      background-color: #2c3e50;
      color: #fff;
      font-size: 16px;
    }

    .form-field input:focus {
      border-color: #3498db;
      outline: none;
    }

    .signin-btn {
      background-color: #3498db;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .signin-btn:hover {
      background-color: #2980b9;
    }

    footer {
      background-color: #1a252f;
      color: #fff;
      text-align: center;
      padding: 10px 0;
      position: absolute;
      width: 100%;
      bottom: 0;
    }

    footer p {
      font-size: 14px;
    }

    .log-message {
      margin-top: 20px;
      font-size: 18px;
      color: #e74c3c;
    }
  </style>
</head>

<body class="authentication-bg authentication-bg-pattern">

  <header>
    <nav>
      <div class="logo">
        <h1>Web-Based Video Library Management System</h1>
      </div>
    </nav>
  </header>

  <main>
    <div class="signin-form">
      <h2>Welcome to VLMS</h2>
      <p>Please Login using your valid credentials.</p><br>

      <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-field">
          <input type="email" id="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="form-field">
          <input type="password" id="password" name="password" placeholder="Password" required>
        </div>

        

        <button type="submit" class="signin-btn">Log In</button>
      </form>

      
      <?php if(session('error')): ?>
        <p class="log-message"><?php echo e(session('error')); ?></p>
      <?php endif; ?>

      
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="log-message"><?php echo e($message); ?></p>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
  </main>

  <footer>
    <div class="footer-content">
      <p>&copy; <span id="current-year"></span> rSalandan's | All Rights Reserved</p>
    </div>
  </footer>

  <script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
  </script>

  <!-- Vendor JS -->
  <script src="<?php echo e(asset('backend/assets/js/vendor.min.js')); ?>"></script>
  <!-- App JS -->
  <script src="<?php echo e(asset('backend/assets/js/app.min.js')); ?>"></script>

</body>

</html>
<?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/auth/login.blade.php ENDPATH**/ ?>