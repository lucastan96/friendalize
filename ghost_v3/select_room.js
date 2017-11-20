$(document).ready(function ()
{
     $(".select-room-btn").click(function () {
         var room_id = $(this).val();
           $.ajax({
            url: "enter_room_action.php",
            type: "POST",
            data: {
                room_id: room_id
            },
            success: function (data) {
                alert(data); 
            },
            error: function ()
            {
alert("data");
                $("#error").html("Error on submitting data");
            }
        });
     });
 });