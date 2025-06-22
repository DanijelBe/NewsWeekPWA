<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please enter both username and password.'); window.location.href='administracija.php';</script>";
        exit;
    }

    $sql = "SELECT username, password FROM korisnik WHERE username = ?";
    
    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param("s", $username); 

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($db_username, $db_password);
                
                $stmt->fetch();

                if (password_verify($password, $db_password)) {
					session_start();
					$_SESSION['loggedin'] = TRUE;

                    header("Location: unos.php");
					
                } else {
                    ("Location: administracija.php");
                }
            } else {
              
                header("Location: administracija.php");
            }
        } else {
            header("Location: administracija.php");
        }

      
        $stmt->close();
    }
}

$conn->close();
?>