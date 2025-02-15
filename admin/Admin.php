<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "quiz_system");


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM `admin` where `del` = 0";
$result = mysqli_query($conn, $sql);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "UPDATE `admin` SET `del` = 1 WHERE `admin_id` = $id";
    if(mysqli_query($conn, $sql)){
        echo "<script> window.location = 'Admin.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .delete-btn {
            padding: 8px 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn:focus {
            outline: none;
        }
    </style>
</head>
<body>

<h1>Admin </h1>
<div class="container">
      <h3><a class="delete-btn" href="add_admin.php">add admin</a></h3>
   
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
                <?php $i = 0;

                 while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo ++$i ?></td>
                        <td><?php echo $row['admin_first_name']; ?></td>
                        <td><?php echo $row['admin_last_name']; ?></td>
                        <td><?php echo $row['admin_email']; ?></td>
                        <td><a onclick="return confirm('are you sure?')" href="Admin.php?id=<?php echo $row['admin_id']; ?>" class="delete-btn">Delete</a></td>
                    </tr>
                <?php } ?>
                <!-- <tr>
                    <td colspan="5" style="text-align:center;">No admin records found</td>
                </tr> -->
            
        </tbody>
    </table>
</div>

</body>
</html>
