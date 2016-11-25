$(document).ready(function(){
    $("#cancel-button").click(function(){
        location.href="/";
    });
    $("#inputfile").attr("disabled", true);
    $('input[name="optionsimagetype"]').on('change', function(){
        if ($(this).val()=='url') {
            $("#inputurl").attr("disabled", false);
            $("#inputfile").attr("disabled", true);
        } else  {
            $("#inputurl").attr("disabled", true);
            $("#inputfile").attr("disabled", false);
        }
    });
});