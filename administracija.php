<!DOCTYPE html>
<html lang="en">
<head>
<?php
session_start();
if(isset($_SESSION['loggedin']) == TRUE){
 
header("Location: unos.php");
}
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsWeek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="text-gray-900">
    <div class="w-full bg-red-500 text-white py-4 px-6 text-center shadow-3xl">
        <h2 class="md:text-6xl font-medium rounded-lg">Newsweek</h2>
    </div>
    <header class="bg-white shadow-md p-4 md:p-6 rounded-b-lg">
        <div>
            <nav>
                <ul class="flex flex-col md:flex-row space-y-3 md:space-y-0  md:space-x-16 justify-center">
                    <li><a href="index.php" class="text-gray-700 hover:text-red-600 font-medium transition duration-300 ease-in-out px-3 py-2 rounded-md">Home</a></li><li>|</li>
                    <li><a href="kategorija.php?category=USA" class="text-gray-700 hover:text-red-600 font-medium transition duration-300 ease-in-out px-3 py-2 rounded-md">U.S.</a></li><li>|</li>
                    <li><a href="kategorija.php?category=World" class="text-gray-700 hover:text-red-600 font-medium transition duration-300 ease-in-out px-3 py-2 rounded-md">World</a></li><li>|</li>
                    <li><a href="administracija.php" class="text-gray-700 hover:text-red-600 font-medium transition duration-300 ease-in-out px-3 py-2 rounded-md">Administracija</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto my-8 p-4 md:p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-red-500 pb-2">Log In</h2>

        
        
        <form method="POST" action="login.php" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="text" id="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
            </div>
			
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 ease-in-out">
                    Login
                </button>
            </div>
        </form>
    </main>

            <footer>
        <div class="container mx-auto text-sm">
            <p>&copy; 2019 NEWSWEEK.</p>
			<h2 class="mb-6 border-b-2 border-gray-300 pb-2"></h2>
        </div>
    </footer>
</body>
</html>