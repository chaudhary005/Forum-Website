<?php
$showError=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include '_dbconnect.php';
    $login_email=$_POST['loginEmail'];
    $login_password=$_POST['loginPassword'];

    if ($_POST['loginEmail'] =="" || $_POST['loginPassword'] == "") {
        $showError="Please enter all the details";
        header("location: /forum/index.php?loginsuccess=false&error=$showError");
    }
    else {
        $sql="SELECT * FROM `users` WHERE `user_email` = '$login_email'";
        $result=mysqli_query($conn, $sql);
        $numRow=mysqli_num_rows($result);
        if($numRow==1){
            while($row=mysqli_fetch_assoc($result)){
                if(password_verify($login_password, $row['user_password'])){
                    session_start();
                    $_SESSION['loggedin']=true;
                    $_SESSION['user_id']=$row['user_id'];
                    $_SESSION['username']=$row['user_name'];
                    header("location: /forum/index.php?loginsuccess=true");
                }
                else{
                    $showError="Invalid Credentials";
                    header("location: /forum/index.php?loginsuccess=false&error=$showError");
                }
            }
        }
        else{
            $showError="Invalid Credentials";
            header("location: /forum/index.php?loginsuccess=false&error=$showError");
        }
    }
}


?>