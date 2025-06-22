<?php

$db_host = 'localhost';
            $db_name = 'newsweek';
            $db_user = 'root';
            $db_pass = '';
			$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
			if ($conn->connect_error) {
			die("ERROR: Could not connect. " . $conn->connect_error);
			}
			$conn->set_charset("utf8mb4");
			?>