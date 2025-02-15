<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "quiz_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$quiz_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$quiz_query = "SELECT * FROM quiz WHERE quiz_id = $quiz_id";
$quiz_result = mysqli_query($conn, $quiz_query);
$quiz = mysqli_fetch_assoc($quiz_result);


$answers_query = "SELECT * FROM `student`s  ,`quiz`q,`result`r
WHERE s.student_id = r.student_id AND
 q.quiz_id = r.quiz_id AND
  q.quiz_id = '$quiz_id'";

// "SELECT a.*, u.username 
//                   FROM answers a
//                   JOIN users u ON a.user_id = u.user_id
//                   WHERE a.quiz_id = $quiz_id
//                   ORDER BY a.answer_id DESC";
$answers_result = mysqli_query($conn, $answers_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Answers - <?php echo htmlspecialchars($quiz['quiz_title']); ?></title>
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
            color: #333;
            margin-bottom: 20px;
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
        .back-btn {
            margin-bottom: 20px;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="back-btn" onclick="window.location='quiz.php'">← Back to Quizzes</button>
        <h1>Answers for: <?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
        <h3><?php echo htmlspecialchars($quiz['quiz_desc'] .' '.$quiz['quiz_faculity']); ?></h3>
        
        <?php if (mysqli_num_rows($answers_result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Student Index</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($answer = mysqli_fetch_assoc($answers_result)): ?>
                <tr>
                    <td><?php echo $answer['student_first_name'].' '.$answer['student_last_nane']; ?></td>
                    <td><?php echo $answer['student_index']; ?></td>

                    <td><?php echo $answer['result']; ?> / <?php echo $quiz['quiz_score']; ?></td>
                    <!-- <td><?php //echo date('M d, Y H:i', strtotime($answer['submitted_at'])); ?></td> -->
                    <td>
                        <a href="view_answers.php?student_id=<?php echo $answer['student_id'] ?>&&quiz_id=<?php echo $quiz_id ?>" class="view-answers">
                            View Details
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No answers found for this quiz.</p>
        <?php endif; ?>
    </div>
</body>
