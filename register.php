<?php
session_start();
require_once('db.php');

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['pwd'];
    $confirm_password = $_POST['confirm_pwd'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            header('Location: login.php');
            exit;
        } else {
            // Registration failed, display error
            $error_message = "Registration failed. Please try again.";
        }
    }
}
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      @apply bg-gray-100;
    }
    h1 {
      @apply text-2xl font-bold text-gray-800;
    }
    form {
      @apply mt-8;
    }
    label {
      @apply block text-gray-700;
    }
    input[type="text"], input[type="password"] {
      @apply block w-full p-2 border border-gray-300 rounded-md;
    }
    input[type="submit"] {
      @apply block w-full p-2 bg-blue-500 text-white rounded-md;
    }
    p {
      @apply text-red-500;
    }
  </style>
</head>
<body>
    <div class="container mx-auto ">
        <h1 class="text-center mt-8 font-bold text-2xl"><a href="https://gjclibrary.com">GJCLibrary</a></h1>
        <h1 class="text-center mt-8">Register</h1>
        <?php if (isset($error_message)) : ?>
            <p class="text-center text-red-500"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="register.php" method="post" class="max-w-md mx-auto mt-8">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required class="mt-3 w-full p-2 border border-gray-300 rounded-md"><br>
            <label for="pwd">Password:</label><br>
            <input type="password" id="pwd" name="pwd" required class="mt-3 w-full p-2 border border-gray-300 rounded-md"><br>
            <label for="confirm_pwd">Confirm Password:</label><br>
            <input type="password" id="confirm_pwd" name="confirm_pwd" required class="mt-3 w-full p-2 border border-gray-300 rounded-md"><br>
            <input type="submit" value="Register" class="mt-3 w-full p-2 bg-blue-500 text-white rounded-md">
        </form>

        <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-blue-500">Login here</a></p>
    </div>
</body>
</html>