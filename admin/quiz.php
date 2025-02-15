<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "quiz_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch all active quizzes
$sql = "SELECT * FROM quiz WHERE del = 0";
$result = mysqli_query($conn, $sql);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "UPDATE `quiz` SET `del` = 1 WHERE `quiz_id` = '$id'";
    if(mysqli_query($conn, $sql)){
        echo "<script> window.location = 'quiz.php';</script>";
    }
}

if(isset($_GET['change_status'])){
    $id = $_GET['change_status'];
    // Toggle status between 0 and 1
    $sql = "UPDATE `quiz` SET `quiz_status` = 1 - `quiz_status` WHERE `quiz_id` = '$id'";
    if(mysqli_query($conn, $sql)){
        echo "<script> window.location = 'quiz.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Management Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .show-questions {
            background-color: #007BFF;
        }

        .view-answers {
            background-color: #6c757d;
        }

        .edit {
            background-color: #FFC107;
        }

        .delete {
            background-color: #DC3545;
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quiz Management Table</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Faculty</th>
                    <th>Score</th>
                    <th>Number of Questions</th>
                    <th>Status</th>
                    <th>Show Questions</th>
                    <th>View Answers</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['quiz_id'] . "</td>";
                        echo "<td>" . $row['quiz_title'] . "</td>";
                        echo "<td>" . $row['quiz_desc'] . "</td>";
                        echo "<td>" . $row['quiz_faculity'] . "</td>";
                        echo "<td>" . $row['quiz_score'] . "</td>";
                        echo "<td>" . $row['quiz_qu_number'] . "</td>";
                        echo "<td>" . ($row['quiz_status'] == 0 ? 'Active' : 'Inactive') . "</td>";
                        echo "<td><button class='show-questions' onclick=\"window.location='quiz_question.php?id=" . $row['quiz_id'] . "'\">Show</button></td>";
                        echo "<td><button class='view-answers' onclick=\"window.location='answers.php?id=" . $row['quiz_id'] . "'\">View</button></td>";
                        echo "<td>
                                <button class='delete'><a onclick=\"return confirm('Are you sure?')\" href='quiz.php?id=" . $row['quiz_id'] . "'>Delete</a></button>
                                <button class='edit' onclick=\"if(confirm('Are you sure you want to change the status?')) { window.location='quiz.php?change_status=" . $row['quiz_id'] . "'; }\">
                                    " . ($row['quiz_status'] == 0 ? 'Deactivate' : 'Activate') . "
                                </button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No quizzes found</td></tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
