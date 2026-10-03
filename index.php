<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Lost & Found</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <style>

        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: #f5f7fa;
            color: #263238;
        }

        /* NAVBAR */

        .navbar {
            background: #1E3A5F;
            padding: 15px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            text-decoration: none;
            font-size: 21px;
            font-weight: 600;
        }

        .logo span {
            color: #BFD7EA;
        }

        .nav-links {
            display: flex;
            gap: 35px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 5px 2px;
        }

        .nav-links a:hover {
            color: #BFD7EA;
        }

        .register-btn {
            background: white;
            color: #1E3A5F !important;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
        }


        /* HERO */

        .hero {
            background: #EAF2F8;
            padding: 55px 8%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .hero-content {
            max-width: 600px;
        }

        .small-title {
            color: #1E3A5F;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .hero h1 {
            font-size: 36px;
            font-weight: 600;
            letter-spacing: 0;
            line-height: 1.25;
            color: #1E3A5F;
            margin-bottom: 15px;
        }

        .hero h1 span {
            color: #356A95;
        }

        .hero p {
            font-size: 15px;
            font-weight: 400;
            line-height: 1.6;
            color: #536471;
            margin-bottom: 25px;
        }

        .hero-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 11px 18px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-primary {
            background: #1E3A5F;
            color: white;
        }

        .btn-primary:hover {
            background: #142B46;
        }

        .btn-secondary {
            background: white;
            color: #1E3A5F;
            border: 1px solid #1E3A5F;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
        }


        /* SIMPLE HERO BOX */

        .hero-box {
            background: white;
            width: 300px;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
        }

        .hero-icon {
            font-size: 55px;
            margin-bottom: 10px;
        }

        .hero-box h3 {
            color: #1E3A5F;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .hero-box p {
            font-size: 14px;
            margin: 0;
        }


        /* FEATURES */

        .features {
            background: white;
            padding: 50px 8%;
            text-align: center;
        }

        .section-title {
            color: #1E3A5F;
            font-size: 25px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .section-text {
            color: #687780;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .feature-grid {
            max-width: 950px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .feature-card {
            background: #f8fafc;
            border: 1px solid #e1e8ef;
            padding: 25px 20px;
            border-radius: 8px;
        }

        .feature-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .feature-card h3 {
            color: #1E3A5F;
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .feature-card p {
            color: #687780;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.5;
        }


        /* HOW IT WORKS */

        .how-it-works {
            padding: 50px 8%;
            text-align: center;
            background: #f5f7fa;
        }

        .steps {
            max-width: 950px;
            margin: 30px auto 0;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .step {
            background: white;
            padding: 20px 15px;
            border-radius: 8px;
            border: 1px solid #e1e8ef;
        }

        .step-number {
            background: #1E3A5F;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .step h3 {
            color: #1E3A5F;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .step p {
            color: #687780;
            font-size: 12px;
        }


        /* BOTTOM CTA */

        .cta {
            background: #1E3A5F;
            text-align: center;
            padding: 40px 20px;
            color: white;
        }

        .cta h2 {
            color: white;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .cta p {
            font-size: 14px;
            color: #dbe7f1;
            margin-bottom: 18px;
        }

        .cta a {
            background: white;
            color: #1E3A5F;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }


        /* FOOTER */

        .footer {
            background: #152A40;
            color: #cbd5df;
            text-align: center;
            padding: 16px;
            font-size: 12px;
        }


        /* MOBILE */

        @media (max-width: 800px) {

            .navbar {
                flex-direction: column;
                gap: 12px;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                padding: 40px 5%;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-box {
                width: 260px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .steps {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {

            .nav-links {
                gap: 10px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero h1 {
                font-size: 29px;
            }

            .steps {
                grid-template-columns: 1fr;
            }
        }

    </style>

</head>

<body>


<!-- NAVIGATION -->

<nav class="navbar">

    <a href="index.php" class="logo">
        Campus <span>Lost & Found</span>
    </a>

    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="view_items.php">View Items</a>

        <?php if (isset($_SESSION['user_id'])): ?>

            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>
            <a href="register.php" class="register-btn">Register</a>

        <?php endif; ?>

    </div>

</nav>


<!-- HERO -->

<section class="hero">

    <div class="hero-content">

        <div class="small-title">
            CAMPUS LOST & FOUND MANAGEMENT SYSTEM
        </div>

        <h1>
            Find what you've lost.
            <br>
            <span>Return what you've found.</span>
        </h1>

        <p>
            A simple platform for students to report lost and
            found belongings, search for items, and submit claims
            securely within the campus community.
        </p>

        <div class="hero-buttons">

            <a href="report_item.php" class="btn-primary">
                Report an Item
            </a>

            <a href="view_items.php" class="btn-secondary">
                View Items
            </a>

        </div>

    </div>


    <div class="hero-box">

        <div class="hero-icon">
            🔎
        </div>

        <h3>
            Campus Lost & Found
        </h3>

        <p>
            Connecting students with their
            lost belongings.
        </p>

    </div>

</section>


<!-- FEATURES -->

<section class="features">

    <h2 class="section-title">
        What You Can Do
    </h2>

    <p class="section-text">
        Simple features to help manage lost and found items.
    </p>

    <div class="feature-grid">

        <div class="feature-card">

            <div class="feature-icon">📝</div>

            <h3>Report an Item</h3>

            <p>
                Report an item you have lost or found
                with important details.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">🔍</div>

            <h3>Search Items</h3>

            <p>
                View reported items and check whether
                your belongings have been found.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">🤝</div>

            <h3>Submit a Claim</h3>

            <p>
                Submit a claim with details to help
                verify ownership.
            </p>

        </div>

    </div>

</section>


<!-- HOW IT WORKS -->

<section class="how-it-works">

    <h2 class="section-title">
        How It Works
    </h2>

    <p class="section-text">
        Follow these simple steps.
    </p>

    <div class="steps">

        <div class="step">

            <div class="step-number">1</div>

            <h3>Report</h3>

            <p>
                Report a lost or found item.
            </p>

        </div>


        <div class="step">

            <div class="step-number">2</div>

            <h3>Search</h3>

            <p>
                Browse the reported items.
            </p>

        </div>


        <div class="step">

            <div class="step-number">3</div>

            <h3>Claim</h3>

            <p>
                Submit your claim.
            </p>

        </div>


        <div class="step">

            <div class="step-number">4</div>

            <h3>Return</h3>

            <p>
                Reconnect the item with its owner.
            </p>

        </div>

    </div>

</section>


<!-- CTA -->

<section class="cta">

    <h2>
        Lost or found something?
    </h2>

    <p>
        Join the campus community and report it today.
    </p>

    <a href="register.php">
        Get Started
    </a>

</section>


<!-- FOOTER -->

<footer class="footer">

    © 2026 Campus Lost & Found Management System

</footer>


</body>
</html>