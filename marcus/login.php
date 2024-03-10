<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
     body {
        background-image: url('background.png'); 
        background-size: cover; 
        background-repeat: no-repeat; 
        background-attachment: fixed; 
    }
    .container {
    width: 550px;
    height: 1000px;
    margin: 0 auto;
    margin-top: 150px;
    padding: 50px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 1); 
    background-color: rgba(0, 0, 0, .2); 
    border-radius: 20px; 
}
.form-group {
    margin-bottom: 30px;
}

/* Update form input colors */
.form-control {
    background-color: rgba(255, 255, 255, 0.1);
    color: white; 
    border-color: #b1d4ed; 
}

.form-group label {
            color: white; 
        }

.btn-primary {
    background-color: #00b894; /* Deep blue button background */
    border-color: #4b7bec; /* Deep blue button border */
    color: #ffffff; /* White text */
}

.btn-primary:hover {
    background-color: #55efc4; /* Darker deep blue on hover */
    border-color: #3867d6;
}

.alert {
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 10px;
}

.alert-danger {
    color: #d63031; /* Dark red text */
    background-color: #fab1a0; /* Light red background */
    border-color: #e17055; /* Light red border */
}

.alert-success {
    color: #00b894; /* Dark green text */
    background-color: #55efc4; /* Light green background */
    border-color: #00b894; /* Light green border */
}


</style>

<body>

<div class="container">
    <?php
    session_start();
    require_once "database.php";

    // Handle comment submission
    // Handle comment submission
if(isset($_POST["submit_comment"])) {
    $comment = $_POST["comment"];
    $user_id = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

    // Insert the comment into the database
    $sql = "INSERT INTO comments (user_id, comment) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $comment);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

    
    // Fetch comments from the database
    $sql = "SELECT * FROM comments ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    ?>
    <form action="index.html" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
    </form>
    <div><p style="color: white;">Not Registered yet? <a href="register.php" style="color: white;"> Sign up</a></p></div>

<form action="index.php" method="post">
    <div class="mb-3">
        <label for="comment" class="form-label" style="color: white;">Your Comment:</label>
        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary" name="submit_comment">Submit</button>
</form>

<hr>

    <?php
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";
        echo "<p class='card-text'>{$row['comment']}</p>";
        echo "<p class='card-text'><small class='text-muted'>Posted on {$row['created_at']}</small></p>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
</body>
</html>
