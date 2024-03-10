<?php
include 'database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commenter_name = $_POST['commenter_name'];
    $comment_text = $_POST['comment_text'];
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "log_register";
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "INSERT INTO comment (commenter_name, comment_text) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $commenter_name, $comment_text);
    if ($stmt->execute() === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    mysqli_close($conn);
}
?>