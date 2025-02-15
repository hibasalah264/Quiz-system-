<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "quiz_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['new_questions']) && !empty($_POST['new_questions'])) {
        $quiz_id = $_GET['id'];
        $new_questions = $_POST['new_questions'];
        
        foreach($new_questions as $question_text) {
            if(!empty($question_text)) {
                $question_text = mysqli_real_escape_string($conn, $question_text);
                $insert_sql = "INSERT INTO question (quiz_id, question) VALUES ('$quiz_id', '$question_text')";
                
                if(!mysqli_query($conn, $insert_sql)) {
                    $error = "Error adding question: " . mysqli_error($conn);
                    break;
                }
            }
        }
        
        if(!isset($error)) {
            $_SESSION['success'] = "Questions added successfully!";
            header("Location: quiz_question.php?id=$quiz_id");
            exit();
        }
    }
}

if(isset($_GET['id'])){
    $quiz_id = $_GET['id'];
    
    // Fetch quiz details
    $quiz_sql = "SELECT * FROM `quiz` WHERE `quiz_id` = '$quiz_id'";
    $quiz_result = mysqli_query($conn, $quiz_sql);
    $quiz = mysqli_fetch_assoc($quiz_result);

    $questions_sql = "SELECT * FROM `question` WHERE `quiz_id` = '$quiz_id'";
    $questions_result = mysqli_query($conn, $questions_sql);
    $questions = mysqli_fetch_all($questions_result, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions - <?php echo $quiz['quiz_title']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .question-card {
            margin-bottom: 20px;
        }

        textarea {
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
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST" action="add_question.php?id=<?php echo $quiz_id; ?>">
            <?php
            // Display success/error messages
            if(isset($_SESSION['success'])) {
                echo "<div class='success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            }
            if(isset($error)) {
                echo "<div class='error'>$error</div>";
            }

             $number = $quiz['quiz_qu_number'] - count($questions);
            for($i = 1; $i <= $number; $i++){
                echo "<div class='question-card'>";
                echo "<p>Question $i:</p>";
                echo "<textarea name='new_questions[]' placeholder='Enter question text' required></textarea>";
                echo "</div>";
            }
            ?>
        <button type="button" onclick="window.history.back()">Back</button>

            <button onclick="return confirm('Are you sure you want to add these questions?')" name="save" type="submit">Add Questions</button>
        </form>
    </div>
</body>
</html>
