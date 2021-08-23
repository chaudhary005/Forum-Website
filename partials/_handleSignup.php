<?php
$showError=false;
$showAlert=false;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include '_dbconnect.php';
    $userName=$_POST['userName'];
    $userEmail=$_POST['signupEmail'];
    $userPassword=$_POST['signupPassword'];
    $cPassword=$_POST['signupcPassword'];

    if($_POST['signupEmail']=="" || $_POST['signupPassword']=="" || $_POST['signupcPassword']==""){
        $showError="Please fill all the fields";
        header("location: /forum/index.php?signupsuccess=false&error=$showError");
    }
    else{
        // if username already exists
        $sqlexists="SELECT * FROM `users` WHERE `user_email` = '$userEmail'";
        $result=mysqli_query($conn, $sqlexists);
        $numRowExists=mysqli_num_rows($result);
        if ($numRowExists>0) {
            $showError="Email already in use";
        }
        else{
            if($userPassword==$cPassword){
                $hash=password_hash($userPassword, PASSWORD_DEFAULT);
                $sql="INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `timestamp`) VALUES ('$userName', '$userEmail', '$hash', current_timestamp())";
                $result=mysqli_query($conn, $sql);
                if($result){
                    $showAlert=true;
                    header("location: /forum/index.php?signupsuccess=true");
                    exit();
                }
            }
            else{
                $showError = "Passwords do not match!";
            }
        }
        header("location: /forum/index.php?signupsuccess=false&error=$showError");
    }

}



?>