function scTop() {
    $(".msgs").animate({scrollTop: $(".msgs")[0].scrollHeight});
}
function load_new_stuff() {
    var id = $(".id").val();
    localStorage['lpid'] = $(".msgs .msg:last").attr("title");
    var loadmsg = "msgs.php";
    $(".msgs").load(loadmsg, function () {
        if (localStorage['lpid'] != $(".msgs .msg:last").attr("title")) {
            scTop();
        }
    });
//    var loadmsg = "msgs.php?chat_id =" + id;

//    $(".msgs").load("msgs.php");s
    $(".ready").load("ready.php");
//    var loadUser = "users.php?chatroom_id =" + id;

//    $(".users").load("users.php");

}
var t;
function display(){
    document.getElementById("countdown").innerHTML = count;
} 
function countdown() {
   display();
   var elem = document.getElementById("countdown");
    if (count > 20) {

        elem.style.color = "green";
        elem.innerHTML = "0" + "0" + ":" + count;
    }
    else if (count <= 20  && count >=10) {
        elem.style.color = "orange";
        elem.innerHTML = "0" + "0" + ":" + count;

    }
    else if (count < 10 && count >=0) {
        elem.style.color = "red";
        elem.innerHTML = "0" + "0" + ":0" + count;

    }
    if(count ==-1){
        cdpause();
        elem.innerHTML="";
    }
    else if (count ==0) {
//           alert(count);
          $(".timer").load("timer.php");
      elem.innerHTML="";
    } else {
          count--;
          t =setTimeout("countdown()",1000);
    }

}
function cdpause(){
    clearTimeout(t);
}
function reset(seconds){
    cdpause();
    count = seconds;
    display();
}
//function my_function(x) {
////    var seconds = 30;
//    var countdownTimer = setInterval('secondPassed(x)', 1000);
//}

$(document).ready(function ()
{
//    alert("ellooo");
    scTop();
    
    $("#vote-btn").click(function () {
        var voted = $("input[name='voted_id']:checked").val();

        alert(voted);
        $.ajax({
            url: "vote_action.php",
            type: "POST",
            data: {
                voted: voted
            },
            success: function () {
                
//                $("#ready-btn").text("Waiting for others");
//                $("#ready-btn").prop('disabled', true);
//                alert(data);
                $(".timer").load("timer.php");
            },
            error: function ()
            {

                $("#error").html("Error on submitting data");
            }
        });
    });

    $("#msg_form").on("submit", function () {
        t = $(this);
        id = $("#room_id").val();
        val = $(this).find("input[type=text]").val();
        if (val != "") {
            t.after("<span id='send_status'>Sending.....</span>");
            $.post("send.php", {content: val, room_id: id}, function (data) {
                load_new_stuff();
                $("#send_status").remove();
                t[0].reset();
            });
        }
        return false;
    });

});

setInterval(function () {
    load_new_stuff();
}, 1000);

//
//setInterval(function () {
//  $(".timer").load("timer.php");
//}, 1000);