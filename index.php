<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex justify-center items-center bg-gray-100">
    <div class="max-w-md p-6 bg-white rounded shadow-md">
        <h1 class="text-3xl font-bold mb-4">Welcome to our GJC Library! 
        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">PHP is used in here</span></h1>
        <p class="text-lg mb-3">Choose an option below:</p>
        <ul class="list-none mb-0">
            <li class="mb-3"><a class="text-blue-600 hover:text-blue-900" href="login.php">Login</a></li>
            <li><a class="text-blue-600 hover:text-blue-900" href="register.php">Register</a></li>
        </ul>
        <div class="space-y-1 mt-4 mb-[-10px] bg-emerald-300 p-3 text-slate-600 rounded-md">
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                    <p class="font-bold">Thanks for reading this message</p>
                    <p class="text-sm">If you want to visit our current website using Django and Next.js, click the button below: <a href="https://gjclibrary.com" class="text-blue-700 cursor-pointer no-underline hover:underline">Click here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>