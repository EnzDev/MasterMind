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


  <body style="background-image: url('../_img/background.jpg');">
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

    <div id="box"></div>
    <div id="noise"></div>

    <div id="menu" class="">
      <div id="m_cont">
          <div class=""></div>
          <?php for ($p=0; $p < 5 ; $p++) { echo "<div>haha</div>"; } ?>
      </div>
    </div>

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script type="text/javascript">
      $("#menu").click( function(){
        console.log($(this));
        if ($(this).hasClass("active")) {  $(this).attr("class", "");
      }else{ $(this).attr("class", "active"); }
      });
    </script>

    <script type="text/javascript">
    $('a[href="#stat"]').click(function(){
      var page = '\
      <div class="container"> \
        <a href="#" onclick="this.parentNode.parentNode.removeChild(this.parentNode)">x</a> \
        <iframe src="./?stat" id="theframe"></iframe> \
      </div>';

      $("body").append(page);
    })
    </script>

    <?php if (!$finished){ ?>
    <script type="text/javascript" >

    var n = [0,1,2,3]
    var unb = false;

    function drag(ev) { ev.dataTransfer.setData("dt", $(ev.target).attr("class")); }
    function allowDrop(ev) {  ev.preventDefault(); }
    function drop(ev) {
      ev.preventDefault();
      b = $(ev.target).attr("id","m");
      $(".current").find("li").each(function(index) { console.log(index, $(this).is(b)); if ($(this).is(b)){
        console.log("the nth : ", index, "\nn : ",n,"\nIndex of nth : ", n.indexOf(index));

        n.splice(n.indexOf(index),1);
        Gameadd(ev.dataTransfer.getData("dt"), index);
        $(ev.target).attr("id","");
      }; });
      // $("#colors > ul > li."+ev.dataTransfer.getData("dt")).click();
      // var data = ev.dataTransfer.getData("dt");
      console.log();
    }

    function tooglePlayable(plyble){
      if (plyble) {

          $("#submit").click(
            function(){
              var submit = [];
              $(".current li").each(function(){submit.push($(this).attr("class"))});
              $.post("./", {play:submit},function(){location.replace("./")}).then(function() {$("#submit").unbind().attr("class","")});
            }
          ).attr("class","ok");
          $("#colors").find("li").unbind();
          console.log("unbinded");
          unb = true;
      }else {
        $("#submit").unbind().attr("class","");
        if(unb){
          $("#colors").find("li").click(function() {
            Gameadd( $(this).attr("class") );
          });
        }
        unb = false;
      }
    }

    function Gameadd(name, c=-1) {
      n.sort();
      var x = (c==-1) ? n.pop() : c;
      $($(".current li")[x]).attr("class",name);
      $($(".current li")[x]).attr("ondrop","");
      $($(".current li")[x]).attr("ondragover","");

      $($(".current li")[x]).click(function(){
        $($(".current li")[x]).attr("class","undefined");
        $($(".current li")[x]).attr("ondrop","drop(event)");
        $($(".current li")[x]).attr("ondragover","allowDrop(event)");

        n.push(x);
        $($(".current li")[x]).unbind();
        tooglePlayable(false);
      });

      if ($(".current li:not(.undefined)").length == 4){tooglePlayable(true);}
    }

    $("#colors").find("li").click(function() {
      Gameadd( $(this).attr("class") );
    });
    </script>
    <?php }else{ ?>
      <script type="text/javascript">

        $("#submit").click(
            function(){location.replace("./?reset")}
        )
        setTimeout(function () {
            $("#box").toggleClass("open");
        }, 1000);

      </script>
      <?php } ?>
  </body>
</html>
<?php }}
