
<?php
session_start(); 
$conn = mysqli_connect("localhost" , "root" , "" , "quiz_system");


if (isset($_POST['signup'])) {
    
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $index = $_POST['index'];
    $faculty = $_POST['faculty'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO `student`
     (`student_first_name`, `student_last_nane`, `student_index`, `student_faculty`, `student_email`, `student_pass`)
     VALUES ('$firstName', '$lastName', '$index', '$faculty', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        // echo "Sign Up Success";
     //    header("Location: index.php");
     echo "<script> windows.location ='index.php';</script>"; 


}else{
     echo $sql ;
}
}
?>

<!DOCTYPE html>
<html>
  
<head>
           <meta charset="UTF-8" />
           <meta http-equiv="X-UA-Compatible" content="IE=edge" />
           <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>
      Student Registration Form
 </title>
</head>
           
     <!--Body of the Webpage-->
<body bgcolor="Beige">
          
          <!--Start of Form-->
          <div style="margin: auto;width: 40%;">
          <form action="signup.php" method="post">
             <h2>Student Registration Form</h2>
             <p>Fill in this form to register</p>
             <br>
             
           <!--Input elemets for form-->
             <label><b>First Name</b></label> 
             <input type="text" placeholder="Enter your first name" name="first_name" required>
             <br>
             
             <br>
             <label><b>Last Name</b></label>
             <input type="text" placeholder="Enter your last name" name="last_name" required>
             <br>
             <br>
             <label><b>E-mail</b></label>
             <input type="email" placeholder="Enter your e-mail" name="email" required>
             <br>
             <!-- <br>
             <label><b>ID</b></label>
             <input type="ID" placeholder="ID" name="ID" required>
             <br> -->
             <br>
             <label><b>Index</b></label>
             <input type="number" placeholder="Index" name="index" required>
             <br>
             <br>
             
             <label><b>Faculty :</b></label>   
                 <select name="faculty" required>
                 <option value="IT">IT</option>
            <option value="arts">Arts</option>
            <option value="engineering">Engineering</option>
            <option value="business">Business</option>  
                 </select>
           <br>
             <br>
             
        <label for="password"><b>Password:</b></label>
        <input type="password" id="password" name="password" required><br>

             
             
             
           
           <br>
           <button name="signup" type="submit" value="Register">SIGN UP </button>
          </form>
     </div>
</body>
</html>
<!-- Html Document Ends-->
