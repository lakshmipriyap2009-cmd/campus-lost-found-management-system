<?php
session_start();
include "config/database.php";

$sql = "SELECT items.*, users.name
        FROM items
        JOIN users ON items.user_id = users.user_id
        ORDER BY items.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Items - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>View Lost and Found Items</p>
</header>

<nav>
    <a href="index.php">Home</a>

    <?php if (isset($_SESSION["user_id"])) { ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="report_item.php">Report Item</a>
        <a href="claim_item.php">My Claims</a>
        <a href="logout.php">Logout</a>
    <?php } else { ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php } ?>
</nav>

<main>

    <h2>Lost & Found Items</h2>

    <?php if ($result->num_rows > 0) { ?>

        <div class="items-container">

            <?php while ($item = $result->fetch_assoc()) { ?>

                <div class="item-card">

                    <h3>
                        <?php echo htmlspecialchars($item["item_name"]); ?>
                    </h3>

                    <p>
                        <strong>Category:</strong>
                        <?php echo htmlspecialchars($item["category"]); ?>
                    </p>

                    <p>
                        <strong>Type:</strong>
                        <?php echo htmlspecialchars($item["type"]); ?>
                    </p>

                    <p>
                        <strong>Location:</strong>
                        <?php echo htmlspecialchars($item["location"]); ?>
                    </p>

                    <p>
                        <strong>Date:</strong>
                        <?php echo htmlspecialchars($item["item_date"]); ?>
                    </p>

                    <p>
                        <strong>Description:</strong>
                        <?php
                        echo htmlspecialchars(
                            $item["description"]
                        );
                        ?>
                    </p>

                    <p>
                        <strong>Reported By:</strong>
                        <?php echo htmlspecialchars($item["name"]); ?>
                    </p>

                    <p>
                        <strong>Status:</strong>
                        <?php echo htmlspecialchars($item["status"]); ?>
                    </p>

                    <?php if (isset($_SESSION["user_id"])) { ?>

                        <?php if ($item["user_id"] != $_SESSION["user_id"]) { ?>

                            <a
                                href="claim_item.php?item_id=<?php echo $item["item_id"]; ?>"
                                class="btn"
                            >
                                Claim Item
                            </a>

                        <?php } ?>

                    <?php } else { ?>

                        <a href="login.php" class="btn">
                            Login to Claim
                        </a>

                    <?php } ?>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="welcome">
            <h3>No items reported yet.</h3>
            <p>Be the first person to report a lost or found item.</p>
        </div>

    <?php } ?>

</main>

<footer>
    <p>&copy; 2026 Campus Lost & Found Management System</p>
</footer>

</body>
</html>