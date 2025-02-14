<?php
// quiz.php
session_start(); 
$conn = mysqli_connect("localhost", "root", "", "quiz_system");
if(isset($_SESSION['student_faculity'])){

$student_faculity =$_SESSION['student_faculity'];


}elseif(!isset($_SESSION['student_faculity'])){
    // header('index.php');
    echo "<script> window.location ='index.php';</script>"; 

}

// Query to fetch quiz details
$sql = "SELECT * FROM `quiz` WHERE `quiz_faculity` = '$student_faculity' AND
 	`quiz_status` = 0 AND `del` = 0"; // Assuming the table name is 'quizzes'
if( mysqli_query($conn, $sql)){
    $result = mysqli_query($conn, $sql);
}else{
    echo $sql ;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Details</title>
    <style>
        .top-bar {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>

    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .quiz-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>Quiz Application</h1>
        <a href="index.php" style="color: white; margin-right: 15px;">Home</a>
        <a href="quiz.php" style="color: white; margin-right: 15px;">Quiz</a>
        <?php if(isset($_SESSION['student_id'])){ ?>
        <a href="logout.php" style="color: white;">Logout</a>
        <?php } ?>
    </div>
    <h2>Quiz Details</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='quiz-card'>";
            ?>
            <a onclick="return confirm('are you sure?')" href="quiz_question.php?id=<?php echo $row["quiz_id"]; ?>">
                <h3><?php echo $row["quiz_title"]; ?></h3>
            <?php 
            // echo "<a>" . $row["quiz_title"] . "</a>";
            echo "<p>" . $row["quiz_desc"] . "</p>";
            echo "<p>Score: " . $row["quiz_score"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "No quizzes found.";
    }
    mysqli_close($conn);
    ?>
</body>
</html>
