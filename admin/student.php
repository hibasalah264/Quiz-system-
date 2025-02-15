
<?php

  // include 'dashboard.php';
  
session_start();
$conn = mysqli_connect("localhost", "root", "", "quiz_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM `student` WHERE `del` = 0";
$result = mysqli_query($conn, $sql);

if(isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "UPDATE `student` SET `del` = 1 WHERE `student_id` = $id";
    mysqli_query($conn, $sql);
    header('Location: student.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Student Management</title>
    <style>
        body {
            margin: 0;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #007bff;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: Beige;
        }
    </style>
  </head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="quiz.php">Manage Quizzes</a>
        <a href="admin.php">Manage Admins</a>
        <a href="student.php">Manage Students</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">


    <table summary="Students" width="1000" border="10">

      <caption>
       <h1>Students</h1> 
        <hr>
      </caption>
          <tr>
               <th>ID</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th> Index </th>
               <th> Faculty </th>
               <th>Email address </th>
               <th>Action </th>
           </tr>
      </thead>
      <tfoot>
       
      </tfoot>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['student_first_name']}</td>
                        <td>{$row['student_last_nane']}</td>
                        <td>{$row['student_index']}</td>
                        <td>{$row['student_faculty']}</td>
                        <td>{$row['student_email']}</td>
                        <td>
                            <a href='student.php?id={$row['student_id']}'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No students found</td></tr>";
        }
        ?>
      </tbody>

    </table>
    </div>
</body>
</html>
