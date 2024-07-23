<?php

session_start();

require_once("./db_connect.php");
require_once("./functions.php");

$error = false;
$username = $usernameError = $passError = "";

if(isset($_POST['login'])){
  $username = cleanInput($_POST['username']);
  $password = cleanInput($_POST['password']);

  if(empty($username)){
    $error = True;
    $usernameError = "please write your Username";
  }

  if(empty($password)){
    $error = True;
    $passError = "please write your Password";
  }

  if(!$error){
    $password = hash("sha256", $password);

$sql = "SELECT * FROM users WHERE username = '{$username}' and password = '{$password}'";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

if($count =1){
  if($row['status'] == 'adm'){
    $_SESSION['admin'] = $row['id'];
    header("location: dashboard.php");
  } elseif($row['status'] == 'user'){
    $_SESSION['user'] = $row['id'];
    header("location: home.php");
  } else{
    echo "something went wrong";
  }
}

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
    <h1>Login page</h1>

    <form method="post">
      <input type="text" placeholder="Type your Username!" class="form-control" name="username"
        value="<?= $username ?>">
      <p class="text-danger"><?= $usernameError ?></p>
      <input type="password" placeholder="Type your password" class="form-control" name="password">
      <p class="text-danger"><?= $passError ?></p>
      <input type="submit" value="Login now" class="btn btn-primary" name="login">
      <a class="btn btn-outline-primary" href="index.php">Back</a>
    </form>
  </div>
</body>

</html>