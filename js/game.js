var n = [0,1,2,3];
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
  }});
  // $("#colors > ul > li."+ev.dataTransfer.getData("dt")).click();
  // var data = ev.dataTransfer.getData("dt");
  console.log();
}

function tooglePlayable(plyble){
  if (plyble) {

      $("#submit").click(
        function(){
          var submit = [];
          $(".current li").each(function(){submit.push($(this).attr("class")); });
          $.post("./", {play:submit},function(){location.replace("./");}).then(function() {$("#submit").unbind().attr("class","");});
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
