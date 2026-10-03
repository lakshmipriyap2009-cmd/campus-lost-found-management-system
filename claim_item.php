<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";
$item_id = isset($_GET["item_id"]) ? intval($_GET["item_id"]) : 0;

/* Get item details */
if ($item_id > 0) {

    $stmt = $conn->prepare(
        "SELECT item_id, item_name, category, type, location, item_date
         FROM items
         WHERE item_id = ?"
    );

    $stmt->bind_param("i", $item_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    $stmt->close();

} else {

    $item = null;
}

/* Submit claim */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_id = intval($_POST["item_id"]);
    $claim_description = trim($_POST["claim_description"]);
    $user_id = $_SESSION["user_id"];

    if (empty($claim_description)) {

        $message = "Please enter a claim description.";

    } else {

        /* Check whether user already claimed this item */
        $check = $conn->prepare(
            "SELECT claim_id
             FROM claims
             WHERE item_id = ? AND user_id = ?"
        );

        $check->bind_param("ii", $item_id, $user_id);
        $check->execute();

        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {

            $message = "You have already submitted a claim for this item.";

        } else {

            $stmt = $conn->prepare(
                "INSERT INTO claims
                (item_id, user_id, claim_description)
                VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "iis",
                $item_id,
                $user_id,
                $claim_description
            );

            if ($stmt->execute()) {
                $message = "Claim submitted successfully!";
            } else {
                $message = "Failed to submit claim.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Claim Item - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>Claim a Lost or Found Item</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="view_items.php">View Items</a>
    <a href="report_item.php">Report Item</a>
    <a href="logout.php">Logout</a>
</nav>

<main>

    <div class="form-container">

        <h2>Claim Item</h2>

        <?php if (!empty($message)) { ?>

            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php } ?>

        <?php if ($item) { ?>

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

            </div>

            <form method="POST">

                <input
                    type="hidden"
                    name="item_id"
                    value="<?php echo $item["item_id"]; ?>"
                >

                <label>Why do you think this item belongs to you?</label>

                <textarea
                    name="claim_description"
                    rows="6"
                    placeholder="Describe identifying details of the item..."
                    required
                ></textarea>

                <button type="submit">Submit Claim</button>

            </form>

        <?php } else { ?>

            <div class="welcome">

                <h3>Item not found.</h3>

                <p>
                    Please go back and select a valid item.
                </p>

                <a href="view_items.php" class="btn">
                    View Items
                </a>

            </div>

        <?php } ?>

    </div>

</main>

<footer>
    <p>&copy; 2026 Campus Lost & Found Management System</p>
</footer>

</body>
</html>