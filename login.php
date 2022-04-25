<?php
//this script will handle login here
session_start();
//check if the  already logged in;
/// 
if(isset($_SESSION['username']))
{
  header("location: welcomne.php");//to send welcome.php
  exit;
}
require_once "config.php";
$username = $password = "";
$err="";

//if request method is post then
if($_SERVER['REQUEST_METHOD']=="POST"){

  if(empty(trim($_POST['username']))|| empty(trim($_POST['password'])))
  
  {
    //echo"print";
    $err = "please enter  username + password";
      //echo"print 1";
  }

   else{
    $username= trim($_POST['username']);
     $password= trim($_POST['password']);
  }
  //error can be detected

  if(empty($err))
  {
    $sql="SELECT id,username,password FROM users Where username = ?";
    $stmt=mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"s",$param_username);
    $param_username=$username;
    //try to execute the statement
    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);
      if(mysqli_stmt_num_rows($stmt)==1)
      {
        mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password);
        if(mysqli_stmt_fetch($stmt))
        {
          if(password_verify($password,$hashed_password))
          {
            //this means password is correct.allow users to login
            session_start();
            $_SESSION["username"]=$username;
            
            $_SESSION["id"]=$id;
            $_SESSION["loggedin"]=true;
            //redirect users to welcome page
            header("location: welcome.php");
          }
        }

      }
    }
  }
  

}




?>







<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>php login system</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PHP LOGIN SYSTEM</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register.php">Register</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link disabled">Contact Us</a>
        </li>
      </ul>
     
  </div>
</nav>

<div class="container mt-4">
    <h3>Please Login Here: </h3>
    <hr>
    <form action="" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
   
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" name="password" class="form-label">Password</label>
    <input type="password" name="password"  class="form-control" id="exampleInputPassword1" placeholder="Enter password">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>