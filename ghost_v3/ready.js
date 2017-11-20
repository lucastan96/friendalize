$(document).ready(function ()
{
    $("#ready-btn").click(function () {
        var room_id = $("#room_id").val();
        $.ajax({
            url: "ready_action.php",
            type: "POST",
            data: {
                room_id: room_id
            },
            success: function () {
                $("#ready-btn").text("");
//                $("#ready-btn").prop('disabled', true);
//                alert(data); 
            },
            error: function ()
            {

                $("#error").html("Error on submitting data");
            }
        });
    });
});