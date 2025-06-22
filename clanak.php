<!DOCTYPE html>
<html lang="en">
<head>
<?php
session_start();
if(isset($_SESSION['loggedin']) == TRUE){
 
$editor = TRUE;

}
else $editor = FALSE;
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>
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
        <?php
		include 'connect.php';

if (isset($_GET['id']) && !empty($_GET['id']) && $conn !== null) {
    $requested_id = htmlspecialchars($_GET['id']);
    $article_found = false;


        $stmt = $conn->prepare("SELECT id, title, author, category, date, content, image FROM articles WHERE id = ?");
        $stmt->bind_param('s', $requested_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $article = $result->fetch_assoc();
			$id = $article['id'];
            $title = $article['title'];
            $author = $article['author'];
            $category = $article['category'];
            $date = $article['date'];
            $content = $article['content'];
            $image_url = $article['image'];
            $article_found = true;
            $display_image_src = !empty($image_url) ? htmlspecialchars($image_url) : 'https://placehold.co/1000x500/E0F2F7/000?text=Article+Image';
			
                    echo '
                    <article>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 leading-tight">' . htmlspecialchars($title) . '</h2>';
						if($editor == TRUE){
						echo'
						<div class="flex justify-end">
							<a href="editor.php?id=' . htmlspecialchars($id) . '"> <div
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 ease-in-out">
						Edit Article
						</div></a>
						
						</div>
						';
							
							
						}
						
						echo'
                        <p class="text-gray-500 text-sm mb-6">
                            By <span class="font-semibold text-red-600">' . htmlspecialchars($author) . '</span> | ' . htmlspecialchars($date) . ' | In <span class="text-red-600">' . htmlspecialchars($category) . '</span>
                        </p>
                        <img src="' . $display_image_src . '" alt="Article Image" class="w-full h-auto object-cover rounded-lg mb-8 shadow-md">
                        <div class="prose prose-lg max-w-none text-gray-700">
                            <p class="mb-4 leading-relaxed">' . nl2br(htmlspecialchars($content)) . '</p>
                        </div>
                    </article>';
                } else {
                    echo '<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                            <strong class="font-bold">Not Found!</strong>
                          </div>';
                }
        } else {
            echo '<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                    <strong class="font-bold">Missing ID!</strong>
                  </div>';
        }
        ?>
    </main>

            <footer>
        <div class="container mx-auto text-sm">
            <p>&copy; 2019 NEWSWEEK.</p>
			<h2 class="mb-6 border-b-2 border-gray-300 pb-2"></h2>
        </div>
    </footer>
</body>
</html>