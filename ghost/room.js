

var ready_button_interval = setInterval(function () {
  checkReady();
}, 1000);
var message_interval = setInterval(function () {
  load_new_stuff();
}, 1000);

function checkReady() {
  $.ajax({
    url: "ready.php",
    success: function (data) {
      var response = jQuery.parseJSON(data);
      if (response["user_ready"] != 1 && response["num_ready"] != 3)
      {
        var s = '<input type="hidden"  name ="room_id" id="room_id" value=' + response["room_id"] + '><br><button type="button" class="btn btn-square" onclick="readyButton()" id="ready-btn">Ready</button>';
        $('.ready').html(s);
      } else if (response["num_ready"] != 3) {
        $(".timer-container").html('<p>Please wait others to ready </p>');

      } else if (response["num_ready"] == 3) {
        // $(".timer-container").html('<p>HIII</p>');
        clearInterval(ready_button_interval);
        $(".timer-container").load("timer.php");
      }
    },
    error: function ()
    {

      $("#error").html("Error on submitting data");
    }
  });
}

function readyButton() {
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
}
function voteButton(){
  var voted = $("input[name='voted_id']:checked").val();

  $.ajax({
    url: "vote_action.php",
    type: "POST",
    data: {
      voted: voted
    },
    success: function (data) {
//        alert(data);
      var response = jQuery.parseJSON(data);
      // if(response["r"] == 3){
      //   $(".timer-container").load("t_timer.php");
      // }
      // else{
        var s = "room.php?room_id="+ response["room_id"];
        window.location.href = s;
      // }
    },
    error: function ()
    {

      $("#error").html("Error on submitting data");
    }
  });
}
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
}
var t;
function display() {
  document.getElementById("countdown").innerHTML = count;
}
function countdown() {
  display();
  var elem = document.getElementById("countdown");
  if (count > 20) {

    elem.style.color = "green";
    elem.innerHTML = "0" + "0" + ":" + count;
  } else if (count <= 20 && count >= 10) {
    elem.style.color = "orange";
    elem.innerHTML = "0" + "0" + ":" + count;

  } else if (count < 10 && count >= 0) {
    elem.style.color = "red";
    elem.innerHTML = "0" + "0" + ":0" + count;

  }
  if (count == -1) {
    cdpause();
    elem.innerHTML = "";
  } else if (count == 0) {
    //           alert(count);
    $(".timer-container").load("timer.php");
    elem.innerHTML = "";
  } else {
    count--;
    t = setTimeout("countdown()", 1000);
  }

}
function cdpause() {
  clearTimeout(t);
}
function reset(seconds) {
  cdpause();
  count = seconds;
  display();
}
$(document).ready(function ()
{
  scTop();
  checkReady();
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
