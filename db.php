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