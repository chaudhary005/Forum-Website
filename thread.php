<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <style>
    #ques{
        min-height: 50vh;
    }
    </style>
    <title>iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE  thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row=mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];

        $posted_by_id=$row['thread_user_id'];
        $sql2 = "SELECT `user_name` FROM `users` WHERE `user_id` = '$posted_by_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_name'];
    }

    ?>

<?php
    $showAlert = false;
    $method =$_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        //insert into database
        $comment = $_POST['comment'];
        $comment = str_replace("<","&lt;", $comment);
        $comment = str_replace(">","&gt;", $comment);
        $user_id = $_POST['user_id'];
        if($comment != ""){
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$user_id', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your comment has been added!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        }
    }

    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title; ?> </h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum.
                No Spam / Advertising / Self-promote in the forums is not allowed.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Remain respectful of other members at all times.
            </p>
            <p>Posted by: <strong><?php echo $posted_by; ?></strong></p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container">
            <h2>Post a Comment</h2>
                <form action=" '.$_SERVER["REQUEST_URI"].' " method="POST">
                    
                    <div class="mb-2">
                        <label for="exampleFormControlTextarea1">Comment here</label>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        <input type="hidden" name="user_id" value="' .$_SESSION["user_id"]. '">
                    </div><br>
                    <button type="submit" class="btn btn-success">Post comment</button>
                </form>
            </div>';
    }
    else{
        echo '<div class="container">
                <h2>Post a Comment</h2>
                <div class="alert alert-warning my-0" role="alert">
                    Please login to post a comment.
                </div>
            </div>';
    }
    ?>

    <div class="container my-2" id="ques">
        <h1 class="py-2">Discussions</h1>
        <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `comments` WHERE  thread_id = $id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row=mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['comment_id'];
        $content = $row['comment_content'];
        $commentTime=$row['comment_time'];

        $comment_by_id=$row['comment_by'];
        $sql2 = "SELECT `user_name` FROM `users` WHERE `user_id` = '$comment_by_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
    
        echo '<div class="media my-2">
            <img src="img/userdefault.png" width="50px" class="mr-3" alt="...">
            <div class="media-body">
                <p class="my-0"><b>' .$row2['user_name']. '</b> <small>at '.$commentTime.'</small></p>
                <big>'.$content.'</big>
            </div>
        </div>';
    }

    if($noResult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Comments Found</P
          <p class="lead">Be the first to comment.</p>
        </div>
      </div>';
    }

    ?>
    
    </div>     

    <?php include 'partials/_footer.php'; ?>

     <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>