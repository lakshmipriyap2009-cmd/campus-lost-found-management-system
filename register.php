<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $phone = trim($_POST["phone"]);

    if (empty($name) || empty($email) || empty($password)) {
        $message = "Please fill all required fields.";
    } else {

        // Check if email already exists
        $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Email already registered.";

        } else {

            // Securely encrypt the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, phone)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $hashed_password,
                $phone
            );

            if ($stmt->execute()) {
                $message = "Registration successful! You can now login.";
            } else {
                $message = "Registration failed.";
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
    <title>Register - Campus Lost & Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>Campus Lost & Found</h1>
    <p>Create your student account</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="view_items.php">View Items</a>
    <a href="login.php">Login</a>
</nav>

<main>

    <div class="form-container">

        <h2>Student Registration</h2>

        <?php if (!empty($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>

        <form method="POST">

            <label>Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Phone</label>
            <input type="text" name="phone">

            <button type="submit">Register</button>

        </form>

        <p>
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>

</main>

</body>
</html>
