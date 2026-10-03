<?php
session_start();
include "config/database.php";

// Check admin login
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

/* ---------------------------
   Handle Claim Action
---------------------------- */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["claim_id"]) && isset($_POST["claim_action"])) {

        $claim_id = intval($_POST["claim_id"]);
        $claim_action = $_POST["claim_action"];

        if ($claim_action == "Approved" || $claim_action == "Rejected") {

            $stmt = $conn->prepare(
                "UPDATE claims SET status = ? WHERE claim_id = ?"
            );

            $stmt->bind_param("si", $claim_action, $claim_id);
            $stmt->execute();
            $stmt->close();

            // If claim is approved, mark item as Claimed
            if ($claim_action == "Approved") {

                $stmt = $conn->prepare(
                    "UPDATE items
                     SET status = 'Claimed'
                     WHERE item_id = (
                         SELECT item_id
                         FROM claims
                         WHERE claim_id = ?
                     )"
                );

                $stmt->bind_param("i", $claim_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}


/* ---------------------------
   Count Users
---------------------------- */

$user_result = $conn->query(
    "SELECT COUNT(*) AS total FROM users"
);

$user_count = $user_result->fetch_assoc()["total"];


/* ---------------------------
   Count Items
---------------------------- */

$item_result = $conn->query(
    "SELECT COUNT(*) AS total FROM items"
);

$item_count = $item_result->fetch_assoc()["total"];


/* ---------------------------
   Count Claims
---------------------------- */

$claim_result = $conn->query(
    "SELECT COUNT(*) AS total FROM claims"
);

$claim_count = $claim_result->fetch_assoc()["total"];


/* ---------------------------
   Get Claims
---------------------------- */

$claims = $conn->query(
    "SELECT
        claims.claim_id,
        claims.claim_description,
        claims.status,
        claims.created_at,
        items.item_name,
        users.name,
        users.email
     FROM claims
     INNER JOIN items
        ON claims.item_id = items.item_id
     INNER JOIN users
        ON claims.user_id = users.user_id
     ORDER BY claims.created_at DESC"
);


/* ---------------------------
   Get Recent Items
---------------------------- */

$items = $conn->query(
    "SELECT
        items.item_id,
        items.item_name,
        items.category,
        items.type,
        items.location,
        items.status,
        users.name
     FROM items
     INNER JOIN users
        ON items.user_id = users.user_id
     ORDER BY items.created_at DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard - Campus Lost & Found</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <style>

        .dashboard-container {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        .admin-header {
            background: #f1f1f1;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-box {
            background: white;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            flex: 1;
            min-width: 200px;
            text-align: center;
        }

        .stat-box h3 {
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: bold;
        }

        .section {
            background: white;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background: #f2f2f2;
        }

        .action-button {
            padding: 7px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .approve {
            background: #28a745;
            color: white;
        }

        .reject {
            background: #dc3545;
            color: white;
        }

        .logout-button {
            display: inline-block;
            background: #333;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .status {
            font-weight: bold;
        }

    </style>

</head>


<body>


<header>

    <h1>Campus Lost & Found</h1>

    <p>Administrator Dashboard</p>

</header>


<nav>

    <a href="index.php">Home</a>

    <a href="dashboard.php">Student Dashboard</a>

    <a href="logout.php">Logout</a>

</nav>


<main>

<div class="dashboard-container">


    <!-- Admin Welcome -->

    <div class="admin-header">

        <h2>
            Welcome, <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>!
        </h2>

        <p>
            This is the administrator dashboard.
        </p>

        <br>

        <a href="logout.php" class="logout-button">
            Logout
        </a>

    </div>


    <!-- Statistics -->

    <div class="stats">

        <div class="stat-box">

            <h3>Total Users</h3>

            <div class="stat-number">
                <?php echo $user_count; ?>
            </div>

        </div>


        <div class="stat-box">

            <h3>Total Items</h3>

            <div class="stat-number">
                <?php echo $item_count; ?>
            </div>

        </div>


        <div class="stat-box">

            <h3>Total Claims</h3>

            <div class="stat-number">
                <?php echo $claim_count; ?>
            </div>

        </div>

    </div>


    <!-- Claims Section -->

    <div class="section">

        <h2>Manage Claims</h2>

        <?php if ($claims->num_rows > 0) { ?>

        <table>

            <tr>

                <th>Claim ID</th>

                <th>Item</th>

                <th>Claimed By</th>

                <th>Email</th>

                <th>Description</th>

                <th>Status</th>

                <th>Action</th>

            </tr>


            <?php while ($claim = $claims->fetch_assoc()) { ?>

            <tr>

                <td>
                    <?php echo $claim["claim_id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($claim["item_name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($claim["name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($claim["email"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($claim["claim_description"]); ?>
                </td>

                <td class="status">

                    <?php echo htmlspecialchars($claim["status"]); ?>

                </td>

                <td>

                    <?php if ($claim["status"] == "Pending") { ?>

                        <form method="POST" style="display:inline;">

                            <input
                                type="hidden"
                                name="claim_id"
                                value="<?php echo $claim["claim_id"]; ?>"
                            >

                            <button
                                type="submit"
                                name="claim_action"
                                value="Approved"
                                class="action-button approve"
                            >
                                Approve
                            </button>

                        </form>


                        <form method="POST" style="display:inline;">

                            <input
                                type="hidden"
                                name="claim_id"
                                value="<?php echo $claim["claim_id"]; ?>"
                            >

                            <button
                                type="submit"
                                name="claim_action"
                                value="Rejected"
                                class="action-button reject"
                            >
                                Reject
                            </button>

                        </form>

                    <?php } else { ?>

                        No action

                    <?php } ?>

                </td>

            </tr>

            <?php } ?>

        </table>

        <?php } else { ?>

            <p>No claims available.</p>

        <?php } ?>

    </div>


    <!-- Items Section -->

    <div class="section">

        <h2>Reported Items</h2>


        <?php if ($items->num_rows > 0) { ?>

        <table>

            <tr>

                <th>Item ID</th>

                <th>Item Name</th>

                <th>Category</th>

                <th>Type</th>

                <th>Location</th>

                <th>Reported By</th>

                <th>Status</th>

            </tr>


            <?php while ($item = $items->fetch_assoc()) { ?>

            <tr>

                <td>
                    <?php echo $item["item_id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($item["item_name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($item["category"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($item["type"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($item["location"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($item["name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($item["status"]); ?>
                </td>

            </tr>

            <?php } ?>

        </table>

        <?php } else { ?>

            <p>No items reported yet.</p>

        <?php } ?>

    </div>


</div>

</main>


<footer>

    <p>
        &copy; 2026 Campus Lost & Found Management System
    </p>

</footer>


</body>

</html>
