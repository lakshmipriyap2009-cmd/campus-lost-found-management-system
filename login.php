<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
            "SELECT user_id, name, email, password FROM users WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];

                header("Location: dashboard.php");
                exit();

            } else {

                $message = "Incorrect password.";
            }

        } else {

            $message = "Email not registered.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>Login to your account</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="view_items.php">View Items</a>
    <a href="register.php">Register</a>
</nav>

<main>

    <div class="form-container">

        <h2>Student Login</h2>

        <?php if (!empty($message)) { ?>
            <p class="message">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>

        </form>

        <p>
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>

    </div>

</main>

</body>
</html>
                

