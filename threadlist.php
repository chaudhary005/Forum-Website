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
    #ques {
        min-height: 50vh;
    }
    </style>
    <title>iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE  category_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row=mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }

    ?>

    <?php
    $showAlert = false;
    $method =$_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //insert into database
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);
        
        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

        $user_id = $_POST['user_id'];
        if ($th_title != "" && $th_desc != "") {
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`,`timestamp`) VALUES ('$th_title', '$th_desc', '$id', $user_id, current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your question has been added! Please wait for the community to respond.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        }
    }

    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forums</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum.
                No Spam / Advertising / Self-promote in the forums is not allowed.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Remain respectful of other members at all times.
            </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        echo '<div class="container">
        <h2>Ask a Question</h2>
        <form action=" '.$_SERVER["REQUEST_URI"].' " method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as shirt and crisp as possible.</div>
            </div>
            <div class="mb-0">
            <input type="hidden" name="user_id" value="' .$_SESSION['user_id']. '">
            </div>
            <div class="mb-2">
                <label for="exampleFormControlTextarea1">Ellaborate your problem</label>
            </div>
            <div class="form-group">
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div><br>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    } else {
        echo '<div class="container">
                <h2>Ask a Question</h2>
                <div class="alert alert-warning my-0" role="alert">
                Please Login to ask a question.
                </div>
            </div>';
    }

    ?>

    <div class="container my-2" id="ques">
        <h1 class="py-2">Browse Questions</h1>
<?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `threads` WHERE  thread_cat_id = $id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while ($row=mysqli_fetch_assoc($result)) {
        $noResult = false;
        $id=$row['thread_id'];
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_time=$row['timestamp'];

        $thread_user_id=$row['thread_user_id'];
        $sql2 = "SELECT `user_name` FROM `users` WHERE `user_id` = '$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
    
        echo '<div class="media">
            <img src="img/userdefault.png" width="50px" class="mr-3" alt="...">
            <div class="media-body">
                
                <h5 class="my-0"> <a class="text-dark text-decoration-none" href="thread.php?threadid='.$id.'"><big>'.$title.'</big></a></h5>
                <big>'.$desc.'</big>
                <p class="my-1"><b>Asked by: ' .$row2["user_name"]. '</b> <small>at '.$thread_time.'</small></p>
            </div>
        </div>';
    }

    if ($noResult) {
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Result Found</P
          <p class="lead">Be the first to ask a question.</p>
        </div>
      </div>';}

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