$(document).ready(function(){
    $("#signin-button").click(function(){
        $("#signin-form").submit();
    });
    $("#signup-button").click(function(){
        location.href="signup-form.php";
    });
    $("#post-button").click(function(){
        var msg = $("#post-form").val();
        location.href="post.php/?msg="+ msg;
    });
    $("#filter-input").keypress(function(event) {
        if (event.which == 13 || event.which == 10){
            event.preventDefault();
            var filter = $("#filter-input").val();
            console.log(filter);
            location.href="index.php?filter="+ filter;
        }
    });
    $(".post-header-delete").click(function(){
        var id = $(this).parent().parent().attr('id');
        location.href="delete.php/?id="+ id;
    });

});