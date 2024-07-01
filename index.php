<?php

require_once("./db_connect.php");

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

$layout = "";

if(mysqli_num_rows($result) == 0){
  $layout = "No result";
} else {
  $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
  foreach($row as $value){
    $layout .= "<div><div class='card' style='width: 18rem;'>
    <div class='card-body'>
      <h5 class='card-title'>{$value["name"]}</h5>
      <p class='card-text'>{$value["username"]}</p>
      <p class='card-text'>{$value["email"]}</p>
      <p class='card-text'>{$value["date_of_birth"]}</p>
      <a href='details.php?id={$value["id"]}' class='btn btn-primary'>Details</a>
      <a href='delete.php?id={$value["id"]}' class='btn btn-danger'>Delete</a>
      <a href='update.php?id={$value["id"]}' class='btn btn-warning'>Update</a>
    </div>
  </div></div>";
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
  <nav class="navbar bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="#">

        <img src="..." alt="Banking" width="30" height="24">
        <a class="navbar-brand" href="login.php">Login</a>
        <a class="navbar-brand" href="register.php">register</a>
      </a>
    </div>
  </nav>
  <?= $layout ?>
</body>

</html>