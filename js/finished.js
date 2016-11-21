$("#submit").click(
    function(){ location.replace("./?reset"); }
);
setTimeout(function () {
    $("#box").toggleClass("open");
}, 1000);
