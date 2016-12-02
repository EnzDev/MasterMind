<?php class Home{
  function __construct(){}
  function launch(){
?>
<!DOCTYPE html>
<html>
<head>
  <head>
    <meta charset="utf8">
    <link rel="stylesheet" href="_style/reset.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="_style/login.css" media="screen" title="no title" charset="utf-8">
    <title>Login</title>

    <script src="https://use.fontawesome.com/7465c97451.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

  </head>
  <body>
    <div class="container">
      <ul>
        <li id="log" class="item active" onclick='displaylogin()'>Login</li>
        <li id="reg" class="item" onclick='displayreg()'>Register</li>
      </ul>
      <div class="form_cont">
        <form id="login" method="post" action="index.php">
            <fieldset>
              <div class="item input">
                <label for="input_username"><i class="fa fa-user" aria-hidden="true"></i></label>
                <input name="username" id="input_username" class="textfield" type="text" placeholder="Utilisateur">
              </div>

              <div class="item input">
                <label for="input_password"><i class="fa fa-key" aria-hidden="true"></i></label>
                <input name="password" id="input_password" class="textfield" type="password" placeholder="Mot de passe">
              </div>
              <!-- <div class="item">
                <label for="input_color"><i class="fa fa-eye-slash" aria-hidden="true"></i>&nbsp;Mode colorblind</label>
                <input type="checkbox" name="blindcolor" value="">
              </div> -->
              <input value="Login" type="submit" class="item">
            </fieldset>
        </form>
        <form id="register" method="post" action="register.php" style="display: none">
            <fieldset>
              <div class="item input">
                <label for="input_username"><i class="fa fa-user" aria-hidden="true"></i></label>
                <input name="username" id="input_username" class="textfield" type="text" placeholder="Utilisateur">
              </div>
              <br>
              <div class="item input">
                <label for="input_password"><i class="fa fa-key" aria-hidden="true"></i></label>
                <input name="password" id="input_password" class="textfield" type="password" placeholder="Mot de passe">
              </div>
              <div class="item input">
                <label for="confirm_password"><i class="fa fa-key" aria-hidden="true"></i></label>
                <input name="c_password" id="input_password" class="textfield" type="password" placeholder="Confirmation">
              </div>

              <input class="item" value="Register" type="submit">
            </fieldset>
        </form>
        <?php if (isset($_SESSION["alert"])) { ?><div class="alert"><br>
          <?php
           echo $_SESSION["alert"];
           session_unset($_SESSION["alert"]);
          ?>
        </div>
        <?php }  ?>
      </div>

    </div>
    <script type="text/javascript">
      function displayreg() {
        $("#log").removeClass("active");
        $("#reg").addClass("active");

        $("#login").hide(200).then($("#register").show(200));
      }

      function displaylogin() {
        $("#reg").removeClass("active");
        $("#log").addClass("active");

        $("#register").hide(200).then($("#login").show(200));
      }
    </script>
  <body>

<?php }} ?>
