<?php
session_start();
include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT admin_id, name, email, password
             FROM admins
             WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $admin = $result->fetch_assoc();

            /*
             * Temporary check because the admin password
             * was entered directly in phpMyAdmin.
             */
            if (password_verify($password, $admin["password"])) {

                $_SESSION["admin_id"] = $admin["admin_id"];
                $_SESSION["admin_name"] = $admin["name"];
                $_SESSION["admin_email"] = $admin["email"];

                header("Location: admin_dashboard.php");
                exit();

            } else {

                $message = "Incorrect password.";
            }

        } else {

            $message = "Admin email not registered.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>Administrator Login</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="login.php">Student Login</a>
</nav>

<main>

    <div class="form-container">

        <h2>Admin Login</h2>

        <?php if (!empty($message)) { ?>

            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php } ?>

        <form method="POST">

            <label>Email</label>
            <input
                type="email"
                name="email"
                required
            >

            <label>Password</label>
            <input
                type="password"
                name="password"
                required
            >

            <button type="submit">
                Admin Login
            </button>

        </form>

    </div>

</main>

<footer>
    <p>&copy; 2026 Campus Lost & Found Management System</p>
</footer>

</body>
</html>