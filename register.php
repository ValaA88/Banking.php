<?php

require_once("./db_connect.php");
require_once("./functions.php");

$error = false;

$name = $nameError = $username = $usernameError = $email = $emailError = $date_of_birth = $dateError = $passError = "";

if(isset($_POST['register'])){

  $username = cleanInput($_POST['username']);
  $password = cleanInput($_POST['password']);
  $name = cleanInput($_POST['name']);
  $email = cleanInput($_POST['email']);
  $date_of_birth = cleanInput($_POST['date_of_birth']);

  #name validation
  if(empty($name)){
    $error = true;
    $nameError = "This field can not be empty";
  } elseif(strlen($name) < 3){
    $error = True;
    $nameError = "Name must be at last 3 chars";
  } elseif(!preg_match("/^[a-zA-Z\s]+$/", $name)){
    $error = True;
    $nameError =  "First name must contain only letters and spaces";
  }

  #username validation
  if(empty($username)){
    $error = true;
    $usernameError = "This field can not be empty";
  } elseif(strlen($username) < 3){
    $error = True;
    $usernameError = "Username must be at last 3 chars";
  } elseif(!preg_match("/^[a-zA-Z\s]+$/", $username)){
    $error = True;
    $usernameError =  "Username must contain only letters and spaces";
  }

  #pass validation
  if(empty($password)){
    $error = True;
    $passError = "This field can not be empty";
  } elseif(strlen($password) < 6){
    $error = True;
    $passError = "Password must be at last 6 chars";
  }


  #email validation
  if(empty($email)){
    $error = True;
    $emailError = "This field can not be empty";
  } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = True;
    $emailError = "Please type a valid email";
  } else {
    $sql = "SELECT * FROM users WHERE email = '{$email}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) != 0){
      $error = True;
      $emailError = "email already exists";
    }
  }

  #date of birth validation
  if(empty($date_of_birth)){
    $error = True;
    $dateError = "This field can not be empty";
  }

  if(!$error){
    $password = hash("sha256", $password);

    $sqlInsert = "INSERT INTO `users`(`username`, `password`, `name`, `email`, `date_of_birth`) VALUES ('{$username}','{$password}','{$name}','{$email}','{$date_of_birth}')";

    $resultInsert = mysqli_query($conn, $sqlInsert);
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="name" placeholder="Type your full name" class="form-control" value="<?= $name ?>">
      <p class="text-danger"><?= $nameError ?></p>
      <input type="text" name="username" placeholder="Type your username" class="form-control" value="<?= $username ?>">
      <p class="text-danger"><?= $usernameError ?></p>
      <input type="password" name="password" placeholder="Type your password" class="form-control">
      <p class="text-danger"><?= $passError ?></p>
      <input type="email" name="email" placeholder="Type your email" class="form-control" value="<?= $email ?>">
      <p class="text-danger"><?= $emailError ?></p>
      <input type="date" name="date_of_birth" class="form-control" value="<?= $date_of_birth ?>">
      <p class="text-danger"><?= $dateError ?></p>

      <input type="submit" name="register" value="Register now" class="btn btn-primary">
      <a class="btn btn-outline-primary" href="index.php">Back</a>
    </form>
  </div>
</body>

</html>