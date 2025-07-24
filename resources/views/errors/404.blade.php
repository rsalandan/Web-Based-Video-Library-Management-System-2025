<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Page Not Found</title>
  <style>
    /* Reset default browser styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Body styles */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #2e3b4e; /* Dark background color */
      color: #dcdfe1; /* Light text color */
      line-height: 1.6;
    }

    /* Header styles */
    header {
      background-color: #1a252f; /* Darker header background */
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    nav .logo h1 {
      font-size: 36px;
      margin: 0;
    }

    /* Main error page container */
    main {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80vh;
    }

    /* Error message box */
    .error-page {
      background-color: #34495e; /* Darker error box */
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 600px;
      text-align: center;
    }

    .error-code {
      font-size: 80px;
      color: #e74c3c; /* Red color for the error code */
      font-weight: bold;
      margin-bottom: 10px;
    }

    .error-title {
      font-size: 24px;
      color: #fff; /* White color for error title */
      margin-bottom: 15px;
    }

    .error-description {
      font-size: 16px;
      color: #bdc3c7; /* Light gray color for description */
      margin-bottom: 25px;
    }

    .error-tip {
      font-size: 14px;
      color: #95a5a6; /* Light gray for tips */
      margin-bottom: 30px;
    }

    .return-home-link {
      font-size: 18px;
      color: #3498db; /* Blue color for the link */
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      border: 2px solid #3498db;
      border-radius: 5px;
      transition: background-color 0.3s, color 0.3s;
    }

    .return-home-link:hover {
      background-color: #3498db;
      color: #fff;
    }

    /* Footer styles */
    footer {
      background-color: #1a252f; /* Dark footer background */
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
  </style>
</head>
<body>

  <header>
    <nav>
      <div class="logo">
        <h1>rSalandan's</h1>
      </div>
    </nav>
  </header>
  
  <main>
    <div class="error-page">
      <div class="error-message-box">
        <h2 class="error-code">404</h2>
        <h3 class="error-title">Page Not Found</h3>
        <p class="error-description">It looks like you may have taken a wrong turn. Don't worry... it happens to the best of us. You might want to check your internet connection.</p>
        <p class="error-tip">Here's a little tip that might help you get back on track.</p>
        <a href="{{ route('dashboard') }}" class="return-home-link">Return to Home</a>
      </div>
    </div>
  </main>
  
  <footer>
    <div class="footer-content">
      <p>&copy; <span id="current-year"></span> rSalandan's | All Rights Reserved</p>
    </div>
  </footer>
  
  <script>
    // Get the current year and set it in the footer
    document.getElementById('current-year').textContent = new Date().getFullYear();
  </script>
  

</body>
</html>
