$("#menu").click( function(){
  // console.log($(this));
  if ($(this).hasClass("active")) {
    $(this).attr("class", "");
  }else{
    $(this).attr("class", "active");
  }
});



$('a[href="#stat"]').click(function(){
  var page = '\
  <div class="container"> \
    <a href="#" onclick="this.parentNode.parentNode.removeChild(this.parentNode)">x</a> \
    <iframe src="./?stat" id="theframe"></iframe> \
  </div>';

  $("body").append(page);
});
