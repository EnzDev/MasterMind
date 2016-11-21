<?php
class results {
  public function __construct(){}
  public function launch($user, $lastGame, $cps){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h1><?php echo $user ?></h1>
    <div class="m_Last"><?php switch ($lastGame) {
      case -1:
        echo 'Vous êtes en partie... <i class="fa fa-tasks" aria-hidden="true"></i>';
        break;
      case 0:
        echo 'Vous venez de perdre une partie <i class="fa fa-frown-o" aria-hidden="true"></i>';
        break;
      case 1:
        echo 'Vous venez de gagner une partie ! <i class="fa fa-smile-o" aria-hidden="true"></i>';
        break;

    } ?></div>

    <div class="m_avg">
      Il te faut environ <?php echo $cps ?> coups pour finir une partie.
    </div>
  </body>
</html>
<?php }}
