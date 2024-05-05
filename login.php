<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['pwd'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        header('Location: login.php?error=1');
        exit;
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
    <div class="container mx-auto">
        <h1 class="text-center mt-8 font-bold text-2xl"><a href="https://gjclibrary.com">GJCLibrary</a></h1>
        <h1 class="text-center mt-8">Login</h1>
        <?php if (isset($_GET['error']) && $_GET['error'] == 1) : ?>
            <p class="text-center text-red-500">Invalid username or password.</p>
        <?php endif; ?>
        <form action="login.php" method="post" class="max-w-md mx-auto mt-8">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required class="mb-2 w-full p-2 border border-gray-300 rounded-md"><br>
            <label for="pwd">Password:</label><br>
            <input type="password" id="pwd" name="pwd" required class="mb-2 w-full p-2 border border-gray-300 rounded-md"><br>
            <input type="submit" value="Login" class="mb-2 w-full p-2 bg-blue-500 text-white rounded-md">
        </form>

        <p class="text-center mt-4">Doesn't have an account? <a href="register.php" class="text-blue-500">Register here</a></p>
    </div>
</body>
</html>