<?php
session_start();

  echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forum">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Top Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

          $sql = "SELECT `category_id`, `category_name` FROM `categories` LIMIT 3";         
          $result = mysqli_query($conn, $sql);
          while ($row=mysqli_fetch_assoc($result)) {
            $Cat_id=$row['category_id'];
            $Cat_name=$row['category_name'];
            echo '<li><a class="dropdown-item" href="/forum/threadlist.php?catid='.$Cat_id.'">' .$Cat_name. '</a></li>';
          }
          

          echo '</ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>';

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
  echo '<form class="d-flex" action="search.php" method="GET">
  <input class="form-control me-2" type="search" placeholder="Search" name="query" aria-label="Search">
  <button class="btn btn-success" type="submit">Search</button>
</form>
<div class="dropdown mx-2">
  <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    '.$_SESSION['username'].'
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="#">Profile</a></li>
    <li><a class="dropdown-item" href="/forum/partials/_logout.php">Logout</a></li>
  </ul>
</div>';
}
else{
  echo '<form class="d-flex" action="search.php" method="GET">
          <input class="form-control me-2" type="search" placeholder="Search" name="query" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
        <div class="mx-2">
          <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>    
          <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>    
        </div>';
    }

    echo '</div>
          </div>
          </nav>';
  include 'partials/_loginModal.php';
  include 'partials/_signupModal.php';
  
  if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == 'true'){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> Your account is created now you can login.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        
  }
  if (isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == 'true'){
    $_GET['logginsuccess']=true;
  }
  // if(!isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == false){
  //   echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
  //           <strong>Error!</strong> '.$_GET['error'].'
  //           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  //       </div>';
  // }
?>