<!DOCTYPE html>
<html lang="en">
<head>
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
	
    <main class="container mx-auto my-8 p-4 md:p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-red-400 pb-2">All News Articles</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
			include 'connect.php';
            
			$stmt = $conn->prepare("SELECT id, title, category, date, image FROM articles ORDER BY date DESC");
			if ($stmt === false) {
			die("ERROR: Could not prepare statement. " . $conn->connect_error);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				while ($article = $result->fetch_assoc()) {
					$articles[] = $article;
				}
			}
			$stmt->close();
			$conn->close();
			if (count($articles) > 0) {
				foreach ($articles as $article) {
					$id = $article['id'];
					$title = $article['title'];
					$category = $article['category'];
					$date = $article['date'];
					$image_url = $article['image'];
                    $display_image_src = !empty($image_url) ? htmlspecialchars($image_url) : 'https://placehold.co/600x350/E0F2F7/000?text=Article+Image';

						echo '
                        <a href="clanak.php?id=' . htmlspecialchars($id) . '">
						<div>
                            <img src="' . $display_image_src . '" alt="Article Image" class="w-full h-48 object-cover rounded-md mb-4 shadow-sm">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">' . htmlspecialchars($title) . '</h3>
                            <p class="text-gray-600 text-sm mb-2">' . htmlspecialchars($date) . ' (' . htmlspecialchars($category) . ')</p>
                        </div></a>';
                    }
                } else {
                    echo '<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                            <strong class="font-bold">No Articles!</strong>
                          </div>';
                }

            
 
            ?>
        </div>
    </main>

            <footer>
        <div class="container mx-auto text-sm">
            <p>&copy; 2019 NEWSWEEK.</p>
			<h2 class="mb-6 border-b-2 border-gray-300 pb-2"></h2>
        </div>
    </footer>
</body>
</html>
