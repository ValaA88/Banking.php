<?php

session_start();

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
  header("location: login.php");
}

if(isset($_SESSION['admin'])){
  header("location: dashboard.php");
}

require_once("./db_connect.php");
$count = "";
// $id = $_SESSION['user'];

$sql = "SELECT * FROM users WHERE id = {$_SESSION['user']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$sqlAccount ="SELECT * FROM `users`
JOIN accounts ON users.id = accounts.user_id";

$resultAccount = mysqli_query($conn, $sqlAccount);
if(mysqli_num_rows($resultAccount) == $_SESSION['user']){ #check if it should be 'user' or 'admin'
  $count = "no result";
} else{
 $rows = mysqli_fetch_all($resultAccount, MYSQLI_ASSOC);
 foreach($rows as $value){
  $count .= "<div>
  <h1>{$value['balance']}</h1>";
 }
}

$layout = "";

if($result){
  $layout = "<div>
  <div class='card' style='width: 18rem;'>

    <h5 class='card-title'>{$row["name"]}</h5>
    <p class='card-text'>{$row["email"]}</p>
    <a href='#' class='btn btn-success'>Details</a>
  </div>
</div>
  </div>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello <?= $row["username"] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="images/default.jpg" alt="Bootstrap" width="30" height="24">
      </a>

      <a class="navbar-brand" href="updateprofile.php">
        Update profile
      </a>

      <a class="navbar-brand" href="logout.php?logout">
        Logout
      </a>
      <a class="navbar-brand" href="account.php?id=<?= $_SESSION['user']?>">
        account
      </a>

      <a class="navbar-brand" href="transfer.php?id=<?= $_SESSION['user']?>">
        Transfer
      </a>
    </div>
  </nav>
  <form>
    <div class="container">
      <div class="row row-cols-3">
        <p>Current amount: <?= $count ?></p>
        <?= $layout ?>


        <h5></h5>
      </div>
    </div>

  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>