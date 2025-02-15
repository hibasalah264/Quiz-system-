<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "quiz_system");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
    $score = mysqli_real_escape_string($conn, $_POST['score']);
    $question_number = mysqli_real_escape_string($conn, $_POST['question_number']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $selected_questions = isset($_POST['selected_questions']) ? $_POST['selected_questions'] : [];
    
    $sql = "INSERT INTO `quiz`(`quiz_title`, `quiz_desc`, `quiz_faculity`, `quiz_score`, `quiz_qu_number`, `quiz_status`)
            VALUES ('$title', '$description', '$faculty', '$score', '$question_number', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        $quiz_id = mysqli_insert_id($conn);
        
        // Associate selected questions with the new quiz
        if (!empty($selected_questions)) {
            foreach ($selected_questions as $question_id) {
                $question_id = mysqli_real_escape_string($conn, $question_id);
                $assoc_sql = "UPDATE questions SET quiz_id = '$quiz_id' WHERE question_id = '$question_id'";
                mysqli_query($conn, $assoc_sql);
            }
        }

    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Quiz added successfully!'); window.location='quiz.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
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

        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Quiz</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label>Quiz Title:</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Faculty:</label>
                <select name="faculty" required>
                <option value="IT">IT</option>
            <option value="arts">Arts</option>
            <option value="engineering">Engineering</option>
            <option value="business">Business</option> 
                </select>
            </div>
            <div class="form-group">
                <label>Quiz Score:</label>
                <input type="number" name="score" required>
            </div>
    <div class="form-group">
        <label>Number of Questions:</label>
        <input type="number" name="question_number" required>
    </div>
    
    
    <div class="form-group">
        <label>Status:</label>
        <select name="status" required>


                    <option value="0">Open</option>
                    <option value="1">Closed</option>
                </select>
            </div>
            <button  type="submit">Add Quiz</button>
        </form>

    </div>
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .question-checkbox {
            margin: 5px 0;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .question-checkbox input {
            margin-right: 10px;
        }
    </style>
</body>
