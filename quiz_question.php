<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "quiz_system");

if (!isset($_SESSION['student_id'])) {
    header("Location: index.php"); 
    exit;
}

if(isset($_GET['id'])){
    $quiz_id = $_GET['id'];
    $sql = "SELECT * FROM `question` WHERE `quiz_id` = '$quiz_id' AND `del` = 0";
    $result = mysqli_query($conn, $sql);
}

// Handle form submission
if(isset($_POST['save'])) {

    $student_id = $_SESSION['student_id'];
    $quiz_id = $_GET['id'];
    
    foreach($_POST['answer'] as $question_id => $answer_text) {
    
        $answer_text = mysqli_real_escape_string($conn, $answer_text);
        
        
        $insert_sql = "INSERT INTO `answer`( `question_id`, `student_id`, `quiz_id`, `answer`)
                      VALUES ('$question_id', '$student_id', '$quiz_id', '$answer_text')";
        mysqli_query($conn, $insert_sql);
    }
    
    echo "<script>alert('Answers submitted successfully!'),window.location ='quiz.php';</script>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Questions</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .question-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            width: 300px;
        }
        input[type="text"] {
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
    <h2>Quiz Questions</h2>
    <form method="POST" action="quiz_question.php?id=<?php echo $quiz_id; ?>">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='question-card'>";
                echo "<p>" . $row["question"] . "</p>";
                echo "<input type='text' name='answer[" . $row["question_id"] . "]' placeholder='Your answer' required>";
                echo "</div>";
            }
        } else {
            echo "No questions found.";
        }
        mysqli_close($conn);
        ?>
        <button onclick="return confirm('are you sure?')" name="save" type="submit">Submit Answers</button>
    </form>
</body>
</html>
