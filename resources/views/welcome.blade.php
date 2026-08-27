<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }

        /* Navbar & Brand */
        .brand-txt {
            font-weight: 700;
            font-size: 1.25rem;
            color: #0f172a;
            text-decoration: none;
        }

        /* Hero Card Style */
        .hero-card {
            background: linear-gradient(135deg, #062c2a 0%, #0d5c58 100%);
            border-radius: 24px;
            padding: 40px;
            color: #ffffff;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .badge-focus {
            background: rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
            border-radius: 9999px;
            padding: 6px 16px;
            font-size: 0.85rem;
            display: inline-block;
            width: fit-content;
        }

        .hero-title {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1.2;
            margin-top: 24px;
            margin-bottom: 16px;
        }

        .hero-desc {
            color: #94a3b8;
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        /* Feature Grid & Cards */
        .feature-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .feature-card {
            background: #fff;
            border: 1px solid rgba(18, 33, 39, .08);
            border-radius: 16px;
            padding: 20px;
        }

        .feature-card h6 {
            font-weight: 700;
            font-size: 0.95rem;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .feature-card p {
            font-size: 0.825rem;
            color: #64748b;
            margin: 0;
            line-height: 1.4;
        }

        /* Responsive Layout Adjustments */
        @media (max-width: 991px) {
            .feature-grid {
                grid-template-columns: 1fr;
            }
            .hero-card {
                margin-bottom: 24px;
            }
        }
    </style>
</head>
<body class="p-4">

    <div class="container-fluid max-width-lg" style="max-width: 1140px; margin: 0 auto;">
        
        <!-- Header Navigasyon -->
        <nav class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 border border-light shadow-sm">
            <a href="{{ route('landing') }}" class="brand-txt ms-2">Todo Pro</a>
            
            <div class="d-flex gap-2">
                @auth
                    <a href="{{ route('tasks.index') }}" class="btn btn-dark rounded-3 px-3">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-3 px-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-dark rounded-3 px-3">Create Account</a>
                @endauth
            </div>
        </nav>

        <!-- Main Content Area: Hero + Features Grid -->
        <div class="row g-3 align-items-stretch">
            
            <!-- Left Side: Hero Card -->
            <div class="col-lg-6">
                <div class="hero-card">
                    <div>
                        <span class="badge-focus mb-2">Built for focus</span>
                        <h1 class="hero-title">Modern task management with private workspaces.</h1>
                        <p class="hero-desc">Organize personal tasks, filter instantly with AJAX, and keep each user account fully isolated and secure.</p>
                    </div>
                    <div class="d-flex gap-2">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-light rounded-3 fw-semibold px-3 py-2">Start Free</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light rounded-3 px-3 py-2">View Account</a>
                        @else
                            <a href="{{ route('tasks.index') }}" class="btn btn-light rounded-3 fw-semibold px-3 py-2">Go to Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Right Side: Feature Grid -->
            <div class="col-lg-6">
                <div class="feature-grid">
                    
                    <div class="feature-card">
                        <h6>Live Dashboard</h6>
                        <p>Search, tabs, pagination, and task actions without page reloads.</p>
                    </div>

                    <div class="feature-card">
                        <h6>Account Control</h6>
                        <p>Registration, login, profile editing, and secure password updates.</p>
                    </div>

                    <div class="feature-card">
                        <h6>Private Tasks</h6>
                        <p>Each user can access only their own tasks and records.</p>
                    </div>

                    <div class="feature-card">
                        <h6>Fast UX</h6>
                        <p>Lightweight UI focused on speed, clarity, and workflow efficiency.</p>
                    </div>

                    <div class="feature-card style-full-width" style="grid-column: 1 / -1;">
                        <h6>Ready for teams and demos</h6>
                        <p>Use seeded data for instant testing, then scale with your own workflow and branding.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>

</body>
</html>