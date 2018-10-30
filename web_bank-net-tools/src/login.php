<?php
session_start();
$errorMsg = "";
$validUser = false;
if(isset($_SESSION["login"])){
  $validUser = $_SESSION["login"] === true;
}
if(isset($_POST["sub"])) {
  $validUser = $_POST["username"] == "admin" && $_POST["password"] == "admin";
  if(!$validUser) $errorMsg = "user or password invalid!";
  else $_SESSION["login"] = true;
}
if($validUser) {
   header("Location: /index.php"); die();
}
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/assets/css/login.css">
<link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>
  <title>Router Login</title>
</head>
<body>
<script src="/assets/js/jquery.min.js"></script>
<div class="login">
  <div class="login-header">
<h1>Login</h1>
  </div>
  <div class="login-form">
  <form name="login-form" method="post">
    <h3>Username:</h3>
    <input type="text" name="username" placeholder="Username"/><br>
    <h3>Password:</h3>
    <input type="password" name="password" placeholder="Password"/>
    <br>
    <input type="submit" value="Login" name="sub" class="login-button"/>
</form>
    <br>
    <?php if(!empty($errorMsg)){ echo '<div class="error-page"><div class="try-again">Error: ' . $errorMsg . '</div></div>';}?>
  </div>
</div>
</body>
</html>


