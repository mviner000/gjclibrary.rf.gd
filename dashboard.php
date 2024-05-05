<?php
session_start();
require_once('db.php');

// Check if user is not logged in via persistent session or regular session
if (!isset($_SESSION['user']) && !isset($_COOKIE['token'])) {
    header('Location: login.php');
    exit;
}

// Validate persistent session if user is not currently logged in
if (!isset($_SESSION['user']) && isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];

    // Retrieve user from database based on token
    $stmt = $db->prepare("SELECT * FROM users WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // No valid user found for the token, redirect to login
        header('Location: login.php');
        exit;
    }

    // Set user session if valid user found
    $_SESSION['user'] = $user;
}

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Clear session variables
    session_unset();
    // Destroy the session
    session_destroy();

    // Clear the token cookie
    setcookie('token', '', time() - 3600, '/');

    // Redirect to login page after logout
    header('Location: login.php');
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>GJCLibrary - Dashboard</title>
</head>
<body class="h-full flex justify-center items-center">
  <div class="container mx-auto p-4">
    <nav class="flex justify-center mb-4">
      <ul class="flex justify-center">
        <li class="mr-6">
          <a href="#" class="opacity-50 text-blue-500 hover:text-blue-800 font-extrabold">Dashboard</a>
        </li>
        <li class="mr-6">
          <a href="user-list.php" class="text-emerald-500 hover:text-blue-800 font-bold">Users List</a>
        </li>
      </ul>
    </nav>
    <div class="flex justify-center mb-8">
      <img src="images/session_destroy.jpg" alt="destroy task" class="border-2 border-cyan-700 shadow-md">
    </div>
    <h1 class="text-4xl font-bold text-center mb-4"><a href="https://gjclibrary.com">GJCLibrary</a></h1>
    <h2 class="text-2xl font-medium text-center mb-8">Welcome, <?= $_SESSION['user']['username'];?>!</h2>
    <div class="flex justify-center">
      <a href="dashboard.php?logout=true" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded">Logout</a>
    </div>
  </div>
</body>
</html>