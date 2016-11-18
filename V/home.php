<?php class Home{
  function __construct(){}
  function launch(){
?>
<!DOCTYPE html>
<html>
<head>
  <head>
    <meta charset="utf8">
    <link rel="stylesheet" href="_style/login.css" media="screen" title="no title" charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <div class="alert">
      <?php if (isset($_SESSION["alert"])) {
       echo $_SESSION["alert"];
       session_unset($_SESSION["alert"]);
      }  ?>
    </div>
    <form method="post" action="index.php" >
        <legend>Login</legend>
        <fieldset>
        <div class="item">
          <label for="input_username">Username:</label>
          <input name="username" id="input_username" class="textfield" type="text">
        </div>
        <br>
        <div class="item">
          <label for="input_password">Password:</label>
          <input name="password" id="input_password" class="textfield" type="password">
        </div>

        <input value="Go" type="submit">
        </fieldset>
    </form>


<?php }} ?>
