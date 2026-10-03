<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT claims.*, items.item_name, items.type
     FROM claims
     JOIN items ON claims.item_id = items.item_id
     WHERE claims.user_id = ?
     ORDER BY claims.created_at DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Claims - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>My Claims</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="view_items.php">View Items</a>
    <a href="report_item.php">Report Item</a>
    <a href="my_claims.php">My Claims</a>
    <a href="logout.php">Logout</a>
</nav>

<main>

    <h2>My Submitted Claims</h2>

    <?php if ($result->num_rows > 0) { ?>

        <div class="items-container">

            <?php while ($claim = $result->fetch_assoc()) { ?>

                <div class="item-card">

                    <h3>
                        <?php echo htmlspecialchars($claim["item_name"]); ?>
                    </h3>

                    <p>
                        <strong>Type:</strong>
                        <?php echo htmlspecialchars($claim["type"]); ?>
                    </p>

                    <p>
                        <strong>My Claim:</strong>
                        <?php echo htmlspecialchars($claim["claim_description"]); ?>
                    </p>

                    <p>
                        <strong>Claim Status:</strong>
                        <?php echo htmlspecialchars($claim["status"]); ?>
                    </p>

                    <p>
                        <strong>Submitted On:</strong>
                        <?php echo htmlspecialchars($claim["created_at"]); ?>
                    </p>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="welcome">
            <h3>No claims submitted yet.</h3>
            <p>You have not submitted any item claims.</p>
        </div>

    <?php } ?>

</main>

<footer>
    <p>&copy; 2026 Campus Lost & Found Management System</p>
</footer>

</body>
</html>