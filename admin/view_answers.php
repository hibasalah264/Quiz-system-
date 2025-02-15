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

$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($student_id === 0 || $quiz_id === 0) {
    die("Invalid parameters");
}

// Get quiz details
$quiz_query = "SELECT * FROM quiz WHERE quiz_id = $quiz_id";
$quiz_result = mysqli_query($conn, $quiz_query);
$quiz = mysqli_fetch_assoc($quiz_result);

// Get student details
$student_query = "SELECT * FROM student WHERE student_id = $student_id";
$student_result = mysqli_query($conn, $student_query);
$student = mysqli_fetch_assoc($student_result);

// Get answers
$answers_query = "SELECT * FROM `question`q ,`answer`a ,`student`s WHERE 
q.question_id = a.question_id AND 
a.student_id = '$student_id' AND
 q.quiz_id = '$quiz_id' ";

$answers_result = mysqli_query($conn, $answers_query);

// Handle score submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_score'])) {
    $score = intval($_POST['score']);
    $max_score = intval($quiz['quiz_score']);
    
    // Validate score
    if ($score >= 0 && $score <= $max_score) {
        $update_query = "UPDATE result SET result = $score 
                        WHERE student_id = $student_id AND quiz_id = $quiz_id";
        if (mysqli_query($conn, $update_query)) {
            $success_msg = "Score updated successfully!";
        } else {
            $error_msg = "Error updating score: " . mysqli_error($conn);
        }
    } else {
        $error_msg = "Score must be between 0 and $max_score";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Answers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .input-group {
            margin-bottom: 15px;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .input-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .input-group input[readonly] {
            background-color: #f9f9f9;
            color: #555;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .success-msg {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .error-msg {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>View Answers for <?php echo htmlspecialchars($student['student_first_name'] . ' ' . $student['student_last_nane']); ?></h2>
        <h3>Quiz: <?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
    </div>
    
    <?php if (mysqli_num_rows($answers_result) > 0): ?>
        <form method="post" action="view_answers.php">
            <?php while ($answer = mysqli_fetch_assoc($answers_result)): ?>
            <div class="input-group">
                <label><?php echo htmlspecialchars($answer['question']); ?></label>
                <input type="text" readonly value="<?php echo htmlspecialchars($answer['answer']); ?>">
            </div>
            <?php endwhile; ?>
        </form>
    <?php else: ?>
        <p>No answers found for this student and quiz.</p>
    <?php endif; ?>

    <?php if (isset($success_msg)): ?>
        <div class="success-msg"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if (isset($error_msg)): ?>
        <div class="error-msg"><?php echo $error_msg; ?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="input-group">
            <label>Enter Score (Max: <?php echo $quiz['quiz_score']; ?>)</label>
            <input  type="number" name="score" min="0" max="<?php echo $quiz['quiz_score']; ?>" required>
        </div>
        <div class="input-group">
            <button type="submit" name="submit_score" class="btn">Submit Score</button>
            <button type="button" class="btn" onclick="window.history.back()">Back</button>
        </div>
    </form>
</body>
</html>
