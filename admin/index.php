<?php
session_start();
$conn =  mysqli_connect("localhost", "root", "", "quiz_system");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `admin` WHERE `admin_email` = '$email'
     AND `admin_password` = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($row){
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['admin_first_name'].' '.$row['admin_last_name'];


        // echo "Login Success";
        echo "<script> window.location ='dashboard.php';</script>";


    }else{
        echo "Login Failed";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="index.php" method="post">

        <h2>ADMIN LOGIN</h2>
        <input type="email" name="email" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login" type="submit">Login</button>
    </form>
    
    </form>
</body>
</html>
