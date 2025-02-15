<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "quiz_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_GET['id'])){
    $quiz_id = $_GET['id'];
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
        foreach ($_POST['answer'] as $question_id => $answer) {
            $answer = mysqli_real_escape_string($conn, $answer);
            $update_sql = "UPDATE question SET question = '$answer' WHERE question_id = $question_id";
            
            if (!mysqli_query($conn, $update_sql)) {
                $error = "Error updating question: " . mysqli_error($conn);
                break;
            }
        }
        
        if (!isset($error)) {
            $_SESSION['success'] = "Questions updated successfully!";
            header("Location: quiz_question.php?id=$quiz_id");
            exit();
        }
    }
    
    // Fetch quiz details
    $quiz_sql = "SELECT * FROM `quiz` WHERE `quiz_id` = '$quiz_id'";
    $quiz_result = mysqli_query($conn, $quiz_sql);
    $quiz = mysqli_fetch_assoc($quiz_result);

    
    // Fetch questions for this quiz
    $questions_sql = "SELECT * FROM `question` WHERE `quiz_id` = '$quiz_id'";
    $questions_result = mysqli_query($conn, $questions_sql);
    // $questions = mysqli_fetch_all($questions_result, MYSQLI_ASSOC);

    // $questions = mysqli_fetch_all($questions_result, MYSQLI_ASSOC);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Questions - <?php echo $quiz['quiz_title']; ?></title>
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

        .question-number {
            width: 50px;
        }

        .question-text {
            width: 60%;
        }

        .actions {
            width: 150px;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background-color: #FFC107;
        }

        .delete-btn {
            background-color: #DC3545;
        }

        .add-btn {
            background-color: #007BFF;
            margin-bottom: 20px;
        }

        .question-card {
            background: #fff;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .question-card p {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }

        .question-card input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .new-questions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .new-questions h3 {
            color: #007BFF;
            margin-bottom: 20px;
        }

        .new-question {
            margin-bottom: 20px;
        }

        .new-question p {
            font-weight: bold;
            margin-bottom: 10px;
            color: #444;
        }

        .new-question textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            resize: vertical;
        }

        button[type="submit"] {
            background-color: #28a745;
            padding: 12px 30px;
            font-size: 16px;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }

        /* Container styling */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .question-card {
                padding: 15px;
            }
        }

        /* Input focus states */
        input:focus, textarea:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }

        /* Transition effects */
        .question-card, button, input, textarea {
            transition: all 0.2s ease;
        }

        /* Hover effects */
        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }


    </style>
</head>
<body>

    <div class="form-container">
    <button    type="submit"><a href="add_question.php?id=<?php echo $quiz['quiz_id'] ?>">Add Question </a> </button>

        <form method="POST" action="quiz_question.php?id=<?php echo $quiz_id; ?>">

        <?php
        
            // $row = $questions[$i];
            // echo "<div class='question-card'>";
            // echo "<p>Question " . ($i + 1) . ": " . $row["question"] . "</p>";
            // echo "<input type='text' name='answer[" . $row["question_id"] . "]' placeholder='Your answer' required>";
            // echo "</div>";
        
        
 $i = 0;
        while($row = mysqli_fetch_assoc($questions_result)){
            // for($i = 0; $i < $quiz['quiz_qu_number']; $i++){

            echo "<div class='question-card'>";
            echo "<p>Question " . ++$i .  "</p>";
            echo "<input type='text' value='{$row['question']}' name='answer[" . $row["question_id"] . "]' required>";
            echo "</div>";

        // }
    }
        // Display existing questions
        // if (!empty($questions)) {
        //     for ($i = 0; $i < count($questions); $i++) {
        //         $row = $questions[$i];
        //         echo "<div class='question-card'>";
        //         echo "<p>Question " . ($i + 1) . ": " . $row["question"] . "</p>";
        //         echo "<input type='text' name='answer[" . $row["question_id"] . "]' placeholder='Your answer' required>";
        //         echo "</div>";
        //     }
        // } else {
        //     echo "No questions found.";
        // }
        

        // Add new questions section
       
        ?>

        
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <button type="button" onclick="window.history.back()">Back</button>
        <button name="save" type="submit" onclick="return confirm('Are you sure you want to save these changes?')">Save Changes</button>


    
        </form>
    </div>
