<?php
session_start();
$conn =  mysqli_connect("localhost", "root", "", "quiz_system");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `student` WHERE `student_email` = '$email'
     AND `student_pass` = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($row){

        $_SESSION['student_id']   = $row['student_id'];
        $_SESSION['student_name'] = $row['student_first_name'] .' '.$row['student_last_nane'];
        $_SESSION['student_faculity'] = $row['student_faculty'];

        // echo "Login Success";
        echo "<script> window.location ='quiz.php';</script>"; 

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
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login" type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>

        <!-- <h2>Login</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login" type="submit">Login</button> -->
    </form>
</body>
</html>
