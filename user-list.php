<?php
$db = new PDO('sqlite:users.db');

// Create the users table if it doesn't exist
$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT, password TEXT, token TEXT)");

// Function to generate a new token for a user
function generateToken() {
    return bin2hex(random_bytes(32));
}

// Function to update a user's token
function updateUserToken($username, $token) {
    global $db;
    $stmt = $db->prepare("UPDATE users SET token = :token WHERE username = :username");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
}

// Function to get a user's token
function getUserToken($username) {
    global $db;
    $stmt = $db->prepare("SELECT token FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Example usage
$username = 'testuser';
$token = generateToken();
updateUserToken($username, $token);

// To check if the user has a valid token on login
$storedToken = getUserToken($username);
if ($storedToken && $storedToken === $userProvidedToken) {
    // User is logged in
} else {
    // User is not logged in or token is invalid
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>GJCLibrary - Userlist</title>
</head>

<body class="bg-gray-100 h-full flex justify-center items-center">
    <div class="container mx-auto p-4">
        <nav class="flex justify-center mb-4">
            <ul class="flex justify-center">
                <li class="mr-6">
                    <a href="dashboard.php" class="text-emerald-500 hover:text-blue-800 font-bold">Dashboard</a>
                </li>
                <li class="mr-6">
                    <a href="user-list.php"
                        class="opacity-50 text-blue-500 hover:text-blue-800 font-extrabold">Users List</a>
                </li>
            </ul>
        </nav>
        <div class="flex justify-center mb-8">
            <img src="images/list_users.jpg" alt="User list" class="border-2 border-cyan-700 shadow-md">
        </div>
        <h1 class="text-4xl font-bold text-center mb-4"><a href="https://gjclibrary.com">GJCLibrary</a></h1>
        <h2 class="text-2xl font-medium text-center mb-8">User List</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8 mx-auto max-w-lg">
            <div class="p-4">
                <p class="text-lg font-bold mb-4">Registered Users:</p>
                <ul class="divide-y divide-gray-200">
                    <?php
                    // Fetch and display the list of users
                    $stmt = $db->query("SELECT username FROM users");
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($users as $user) {
                        echo '<li class="py-2">' . htmlspecialchars($user['username']) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>