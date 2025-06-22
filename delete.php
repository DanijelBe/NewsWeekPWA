<?php


		include 'connect.php';
		$id = $_GET['id'] ?? '';
		$sql = "DELETE FROM articles WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $id);
		$stmt->execute();
		header("Location: index.php");
?>