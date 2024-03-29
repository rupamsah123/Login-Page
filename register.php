<?php
require_once "config.php";
$username=$password=$confirm_password="";
$username_err=$password_err=$confirm_password_err="";
if($_SERVER['REQUEST_METHOD']=="POST"){
    //check username is empty or not
    if(empty(trim($_POST["username"])))
    {
        $username_err="user name cannot be blank";
    }
    else{
        $sql="SELECT id FROM users WHERE username=?";//TO PREPARE THE SELECT STATEMENT
        $stmt=mysqli_prepare($conn,$sql);//it will be prepare the statement
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"s",$param_username);
            //set the value param username
            $param_username= trim($_POST['username']);
            //try to execute this statement 
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt)==1)
                {
                    $username_err="this username is laready is taken";
                }
                else{
                    $username=trim($_POST['username']);
                }
            }
            else
            {
                echo"something went wrong";
            }
        }
    }
  mysqli_stmt_close($stmt);
  

//check for password
if(empty(trim($_POST['password'])))
{
  $password_err="password canot be blank";
}
elseif(strlen(trim($_POST['password']))<5)
{
  $password_err="password canot be less than five character";
}
else{
  $password=trim($_POST['password']);
}
//check for confirmation password
if(trim($_POST['password'])!=trim($_POST['confirm_password']))
{
  $password_err="password should be match";
}
//if there was no error, go ahead and insert into database
if(empty($username_err)&& empty($password_err)&& empty($confirm_password))
{
  echo "Working";
  $sql="INSERT INTO users (username,password) VALUES (?,?)";
  echo "Working";
  $stmt=mysqli_prepare($conn,$sql);
  echo "Working";
  if($stmt)
  {
    mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);
    //set these parameters
    $param_username=$username;
    $param_password=password_hash($password,PASSWORD_DEFAULT);
    //TRY TO EXECUTE T5HE QUERY
    if(mysqli_stmt_execute($stmt))
    {
      header("location: login.php");
    }
    else{
      echo"something went wrong....cannot redirect! ";
    }
  }
  mysqli_stmt_close($stmt);

}
mysqli_close($conn);
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
          <a class="nav-link" href="#">About</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link disabled">Contact Us</a>
        </li>
      </ul>
     
  </div>
</nav>

<div class="container mt-4">
    <h3>Please Register Here: </h3>
    <hr>
<form class="row g-3" action=" " method="POST">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="inputPassword4">
  </div>
  <div class="col-12">
  <label for="inputPassword4" class="form-label">confirm_Password</label>
    <input type="password" class="form-control" name="confirm_password" id="inputPassword4">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label>
    <select id="inputState" class="form-select">
      <option selected>Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
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
<!-- //this is  demo of the simple of the simple if the website that we orgainsed by me  this is also helped by me to orgainse the data -->