<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>Student Dashboard</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="view_items.php">View Items</a>
    <a href="report_item.php">Report Item</a>
    <a href="claim_item.php">My Claims</a>
    <a href="logout.php">Logout</a>
</nav>

<main>

    <section class="welcome">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>! 👋</h2>

        <p>
            Welcome to your Campus Lost & Found dashboard.
        </p>

        <div class="buttons">

            <a href="report_item.php" class="btn">
                Report Lost / Found Item
            </a>

            <a href="view_items.php" class="btn">
                View Lost & Found Items
            </a>

            <a href="my_claims.php" class="btn">
                My Claims
            </a>

        </div>
    </section>

    <section class="features">

        <div class="card">
            <h3>📢 Report an Item</h3>
            <p>
                Report an item that you have lost or found on campus.
            </p>
        </div>

        <div class="card">
            <h3>🔍 Find an Item</h3>
            <p>
                View items reported by other students and staff.
            </p>
        </div>

        <div class="card">
            <h3>🤝 Claim an Item</h3>
            <p>
                Submit a claim if you identify your lost belonging.
            </p>
        </div>

    </section>

</main>

<footer>
    <p>&copy; 2026 Campus Lost & Found Management System</p>
</footer>

</body>
</html>