<?php
class results {
  public function __construct(){}
  public function launch($user, $lastGame, $cps, $leader){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="_style/reset.css" media="screen">
    <link rel="stylesheet" href="_style/result.css" media="screen">
  </head>
  <body>

    <h1>Bonjour <?php echo $user ?></h1>
    <div class="m_Last" ><?php switch ($lastGame) {
      case 0:
        echo 'Vous venez de perdre une partie <i class="fa fa-frown-o" aria-hidden="true"></i>';
        break;
      case 1:
        echo 'Vous venez de gagner une partie ! <i class="fa fa-smile-o" aria-hidden="true"></i>';
        break;
      case 9:
        echo 'Vous êtes en partie... <i class="fa fa-tasks" aria-hidden="true"></i>';
        break;
      default:
        echo "haeeem...";
    } ?></div>

    <div class="m_avg">
      Il vous faut environ <?php echo is_numeric($cps) ? round($cps) : $cps ?> coup<?php if(round($cps)>1){echo "s";}?> pour finir une partie.
    </div>

    <div class="m_leader">
      <ul>
        <li>Pseudo
        <li>Parties
        <li>Gagnées
        <li>Moyenne
      </ul>
      <?php foreach ($leader as $cars): ?>
        <ul>
          <li><?php echo $cars["pseudo"]; ?>
          <li><?php echo $cars["games"] ?>
          <li><?php echo $cars["win"] ?>
          <li><?php echo $cars["aver"] ?>
        </ul>
      <?php endforeach; ?>
    </div>
  </body>
</html>
<?php }}
