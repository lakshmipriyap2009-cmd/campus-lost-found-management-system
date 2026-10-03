<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_name = trim($_POST["item_name"]);
    $category = trim($_POST["category"]);
    $type = $_POST["type"];
    $location = trim($_POST["location"]);
    $item_date = $_POST["item_date"];
    $description = trim($_POST["description"]);

    if (
        empty($item_name) ||
        empty($category) ||
        empty($type) ||
        empty($location) ||
        empty($item_date)
    ) {

        $message = "Please fill all required fields.";

    } else {

        $user_id = $_SESSION["user_id"];

        $stmt = $conn->prepare(
            "INSERT INTO items
            (user_id, item_name, category, type, location, item_date, description)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issssss",
            $user_id,
            $item_name,
            $category,
            $type,
            $location,
            $item_date,
            $description
        );

        if ($stmt->execute()) {
            $message = "Item reported successfully!";
        } else {
            $message = "Failed to report item.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Item - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>Report a Lost or Found Item</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="view_items.php">View Items</a>
    <a href="claim_item.php">My Claims</a>
    <a href="logout.php">Logout</a>
</nav>

<main>

    <div class="form-container">

        <h2>Report Item</h2>

        <?php if (!empty($message)) { ?>
            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>Item Name</label>
            <input type="text" name="item_name" placeholder="Example: Black Wallet" required>

            <label>Category</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Electronics">Electronics</option>
                <option value="Books">Books</option>
                <option value="Documents">Documents</option>
                <option value="Clothing">Clothing</option>
                <option value="Accessories">Accessories</option>
                <option value="Other">Other</option>
            </select>

            <label>Report Type</label>
            <select name="type" required>
                <option value="">Select Type</option>
                <option value="Lost">Lost</option>
                <option value="Found">Found</option>
            </select>

            <label>Location</label>
            <input type="text" name="location" placeholder="Example: Library" required>

            <label>Date</label>
            <input type="date" name="item_date" required>

            <label>Description</label>
            <textarea name="description" rows="5"
                placeholder="Describe the item..."></textarea>

            <button type="submit">Submit Report</button>

        </form>

    </div>

</main>

<footer>
    <p>&copy; 2026 Campus Lost & Found Management System</p>
</footer>

</body>
</html>
