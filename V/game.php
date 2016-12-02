<?php class GameView{
  function __construct(){}
  function launch($test, $res, $len, $finished=false, $glen){
$assoc = array("rouge"=>'red', "vert"=>'green', "bleu"=>'blue', "orange"=>'orange', "blanc"=>'white', "violet"=>'purple', "fuchsia"=>'pink', "jaune"=>'yellow');
$points = array(0 =>"undefined" ,1=>"white", 2=>"black" );
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Master-Mind&#160;</title>

    <link rel="shortcut icon" href="_img/logo.png">
    <link rel="stylesheet" href="_style/reset.css" media="screen">
    <link rel="stylesheet" href="_style/game.css" media="screen">


    <script src="https://use.fontawesome.com/7465c97451.js"></script>
  </head>


  <body style="/*background-image: url('./_img/background.jpg');*/">
    <div id="container">
      <!-- <div style="width:5vw;"></div> -->
      <div id="board">

        <div id="before">
          <span id="title">Mastermind</span>
          <!-- <span id="id">Connecté en tant que <a href="./disconnect.php"><?php echo $_SESSION["username"] ?></a></span> -->
          <!-- <span id="id" style="top: 5vh;"><a href="#stat">Voir mes statistiques</a></span> -->
        </div>

        <div id="head"> <!-- Four dots for each try-->
          <!-- ul (flex) for each try -->
          <?php for ($i=0; $i <$glen ; $i++) { ?>
            <ul>
            <?php for ($j=0; $j < 4; $j++) { ?>
              <li class="<?php print_r(isset($res[$i][$j]) ? $points[$res[$i][$j]] : 'undefined') ?>"></li>
            <?php } ?>
          </ul>
          <?php } ?>
        </div>

        <div id="try">
          <?php for ($i=0; $i <$glen ; $i++) { ?>

            <ul <?php if ($i==$len) { echo 'class="current"'; } ?>>
            <?php for ($j=0; $j < 4; $j++) { ?>
              <li class="<?php echo isset($test[$i][$j])?$assoc[$test[$i][$j]]:'undefined' ?>"<?php if ($i==$len){ echo ' ondrop="drop(event)" ondragover="allowDrop(event)"'; }?>></li>
            <?php } ?>
          </ul>
          <?php } ?>
        </div>
        <div id="colors">
          <ul> <!-- or unrevealed -->
            <?php foreach ($assoc as $value) {
              echo '<li class="'.$value.'"    draggable="true" ondragstart="drag(event)"></li>';
            } ?>  <!-- A clic on one of these add the color NOTE : NOW SUPPORT DragAndDrop -->
          </ul>
        </div>
      </div>

      <div id="result">
        <ul style="height:12vh;"></ul> <!-- placeholder for the flex alignement; -->
        <ul style="height:6vh;"></ul> <!-- placeholder for the flex alignement; -->
        <ul class="<?php echo $finished==false?'unrevealed':'revealed' ?>" id="solution"> <!-- or unrevealed -->
          <?php for ($c=0; $c < 4 ; $c++) { ?>
            <li class="<?php echo $finished==false?'undefined':$assoc[$finished[$c]] ?>"></li>
          <?php } ?>
        </ul>
        <?php if (!$finished){ ?>
        <ul id="submit" style="height:10vh;"><div>Submit</div></ul> <!-- submit link -->
        <?php }else{ ?>
        <ul id="submit" class="ok" style="height:10vh;"><div>Rejouer</div></ul>
        <?php } ?>
      </div>
    </div>

    <div class="box_c">
      <div style="height:12vh;"></div>
      <div style="height:6vh;"></div>
      <div id="box"></div>
      <div style="height:10vh;"></div>
    </div>
    <div id="noise"></div>

    <div id="menu" class="">
      <div id="blur"></div>
      <div id="m_cont">
          <iframe src="?stat"></iframe>
      </div>
    </div>

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script src="js/common.js" charset="utf-8"></script>

    <?php if (!$finished){ ?>
      <script src="js/game.js" charset="utf-8"></script>
    <?php }else{ ?>
      <script src="js/finished.js" charset="utf-8"></script>
      <?php } ?>
  </body>
</html>
<?php }}
