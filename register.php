<?php

require_once("./db_connect.php");
require_once("./functions.php");

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

}

?>