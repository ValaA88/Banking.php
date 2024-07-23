<?php

session_start();

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
  header("location: login.php");
}

require_once("./db_connect.php");

$sum = 0;

if(isset($_SESSION['admin'])){
  $id = $_SESSION['admin'];
} elseif(isset($_SESSION['user'])){
  $id = $_SESSION['user'];
}

$sqlJoin = "SELECT * FROM accounts
JOIN users ON users.id = accounts.user_id
WHERE accounts.user_id = $id";
$resultJoin = mysqli_query($conn, $sqlJoin);
if(mysqli_num_rows($resultJoin) == 0){
  $amount = 0;
} else {
  $rows = mysqli_fetch_assoc($resultJoin);
  $amount = "<div>
  <p>{$rows['balance']}</p>
  </div>";
}

$sum = $rows['balance'];

if(isset($_POST['add'])){
  $sum2 = $_POST['add'];
  $sum = $sum + $sum2;
  $sqlNewBalance = "UPDATE accounts SET balance = $sum WHERE `user_id` = $id;";

  $resultNewBalance = mysqli_query($conn, $sqlNewBalance);
  header("location: account.php");
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
  <div>
    <form method="post">
      <h type="text" name="balance" placeholder="Your current balance" class="form-control">Current Balance:
        <?= $amount ?></h>
      <label class="container" for="amount">Amount to add</label>
      <input type="number" id="amount" name="add" required>
      <button type="submit">Add balance</button>
  </div>
  <a class="btn btn-outline-primary" href="home.php?home">Back</a>
  </form>


</body>

</html>