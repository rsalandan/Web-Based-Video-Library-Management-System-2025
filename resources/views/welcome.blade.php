<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>rSalandan's - REQU</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #0f172a;
            color: #f1f5f9;
            line-height: 1.6;
        }

        header {
            background: #1e293b;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
        }

        nav a {
            color: #fff;
            margin-left: 1.5rem;
            text-decoration: none;
            font-weight: 500;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .hero {
            text-align: center;
            padding: 5rem 2rem;
            background: linear-gradient(to right, #1d4ed8, #2563eb);
            color: #fff;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .cta-btn {
            background: #facc15;
            color: #1e293b;
            padding: 0.75rem 1.5rem;
            border: none;
            font-size: 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: bold;
        }

        .section {
            padding: 4rem 2rem;
            text-align: center;
        }

        .section h2 {
            font-size: 2rem;
            color: #3b82f6;
            margin-bottom: 2rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature {
            background: #1e293b;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .feature h3 {
            font-size: 1.25rem;
            color: #facc15;
            margin-bottom: 1rem;
        }

        .feature p {
            font-size: 0.95rem;
            color: #cbd5e1;
        }

        .footer {
            background: #1e293b;
            padding: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .footer a {
            color: #facc15;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">rSalandan's</div>
        <nav>
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                    @endauth
                </div>
            @endif
        </nav>
    </header>

    <section class="hero">
        <h1>Streamline Your Resource Requests</h1>
        <p>REQU System helps manage, track, and approve inventory and resource requests with ease and efficiency.</p>
        <button class="cta-btn">Get Started</button>
    </section>

    <section class="section" id="features">
        <h2>Key Features</h2>
        <div class="features">
            <div class="feature">
                <h3>Simple Requests</h3>
                <p>Submit requests with a user-friendly interface that guides users step-by-step.</p>
            </div>
            <div class="feature">
                <h3>Approval Flow</h3>
                <p>Built-in workflow that handles multi-level approvals quickly and transparently.</p>
            </div>
            <div class="feature">
                <h3>Live Tracking</h3>
                <p>View the status of your requests and inventory allocation in real-time.</p>
            </div>
            <div class="feature">
                <h3>Reports & Logs</h3>
                <p>Powerful analytics and logs to evaluate efficiency and resource use.</p>
            </div>
        </div>
    </section>

    <section class="section" id="about">
        <h2>About REQU</h2>
        <p style="max-width: 700px; margin: 0 auto; color: #cbd5e1;">
            REQU is a smart inventory and request system developed to improve administrative workflow in modern
            organizations. It ensures transparency, accountability, and faster turnaround for all resource requests.
        </p>
    </section>

    <footer style="background-color: #1e293b; color: white; text-align: center; padding: 2rem; font-size: 0.875rem;">
        <p>&copy; <span id="current-year"></span> rSalandan's. All rights reserved.</p>
        <p id="time"></p>
        <script>
            document.getElementById("current-year").textContent = new Date().getFullYear();
        </script>
        <script>
            function updateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };
                document.getElementById('time').textContent = '' + now.toLocaleString('en-US', options);
            }

            updateTime(); // Initial call
            setInterval(updateTime, 1000); // Update every second
        </script>
    </footer>

</body>

</html>
