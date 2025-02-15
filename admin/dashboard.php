<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .welcome-message {
            margin-bottom: 20px;
        }
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .menu a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="content">
        <div class="welcome-message">
            Welcome, <?php if(isset($_SESSION['admin_name'])){
                echo $_SESSION['admin_name'];
            } ?>!
        </div>
        <div class="menu">
            <a href="quiz.php">Manage Quizzes</a>
            <a href="answer.php">Manage answer</a>

            <a href="admin.php">Manage Admin</a>
            <a href="student.php">Manage Students</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>