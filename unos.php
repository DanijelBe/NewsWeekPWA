<!DOCTYPE html>
<html lang="en">
<head>
<?php
session_start();
if(isset($_SESSION['loggedin']) !== TRUE){
 
header("Location: administracija.php");
}
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsWeek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
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
			<form action="logout.php" method="post">	
		<div class="flex justify-end">
                <button type="submit" name="logout_button"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 ease-in-out">
                    Log Out
                </button>
            </div>
	</form>
	
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-red-500 pb-2">Create New NEWSWEEK Article</h2>

        <?php
		include 'connect.php';

        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            return $data;
        }

  

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $conn !== null) {
            $title = sanitize_input($_POST['title'] ?? '');
            $author = sanitize_input($_POST['author'] ?? '');
            $category = sanitize_input($_POST['category'] ?? '');
            $content = sanitize_input($_POST['content'] ?? '');
            $date = date("Y-m-d");
            $image_url = 'images/'; 
			$upload_dir = 'images/';
            $errors = [];

            // Basic validation
            if (empty($title)) $errors[] = "Article Title is required.";
            if (empty($author)) $errors[] = "Author Name is required.";
            if (empty($category)) $errors[] = "Category is required.";
            if (empty($content)) $errors[] = "Article Content is required.";

            // Handle image upload
            if (isset($_FILES['article_image']) && $_FILES['article_image']['error'] == UPLOAD_ERR_OK) {
                $file_name = $_FILES['article_image']['name'];
                $file_tmp_name = $_FILES['article_image']['tmp_name'];
                $file_size = $_FILES['article_image']['size'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $max_file_size = 5 * 1024 * 1024;

                if (!in_array($file_ext, $allowed_extensions)) {
                    $errors[] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
                }
                if ($file_size > $max_file_size) {
                    $errors[] = "File size exceeds the maximum limit of 5MB.";
                }

                if (empty($errors)) {
                    $new_file_name = uniqid('img_', true) . '.' . $file_ext;
                    $destination = $upload_dir . $new_file_name;

                    if (move_uploaded_file($file_tmp_name, $destination)) {
                        $image_url = $destination;
                    } else {
                        $errors[] = "Failed to upload image.";
                    }
                }
            } elseif (isset($_FILES['article_image']) && $_FILES['article_image']['error'] != UPLOAD_ERR_NO_FILE) {
                $errors[] = "Image upload error: " . $_FILES['article_image']['error'];
            }

            if (empty($errors)) {
                    $article_id = uniqid('article_');
					$query = "INSERT INTO articles (id, title, author, category, date, content, image) VALUES ('$article_id', '$title', '$author', '$category', '$date', '$content', '$image_url')";
                    $stmt = $conn->prepare($query);

                    if ($stmt->execute()) {
                        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                                <strong class="font-bold">Success!</strong>
                              </div>';
                    } else {
                        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                                <strong class="font-bold">Saving fail!</strong>
                              </div>';
                    }
                } 
            }
        ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Article Title</label>
                <input type="text" id="title" name="title" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                       value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
            </div>

            <div>
                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author Name</label>
                <input type="text" id="author" name="author" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                       value="<?php echo htmlspecialchars($_POST['author'] ?? ''); ?>">
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="category" name="category" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                    <option value="">Select a category</option>
                    <?php
                    $categories = ["USA", "World"];
                    $selected_category = $_POST['category'] ?? '';
                    foreach ($categories as $cat) {
                        $selected = ($selected_category == $cat) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($cat) . '" ' . $selected . '>' . htmlspecialchars($cat) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="article_image" class="block text-sm font-medium text-gray-700 mb-1">Article Image (Max 5MB, JPG, PNG, GIF)</label>
                <input type="file" id="article_image" name="article_image" accept="image/jpeg, image/png, image/gif"
                       class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Article Content</label>
                <textarea id="content" name="content" rows="10" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
            </div>

			<div class="flex justify-end">
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 ease-in-out">
                    Save Article
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