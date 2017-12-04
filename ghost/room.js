var ready_button_interval = setInterval(function () {
    checkReady();
}, 1000);

var message_interval = setInterval(function () {
    load_new_stuff();
}, 1000);

var profile_info_interval = setInterval(function () {
    $(".player-info").load("player-info.php");
}, 1000);

function checkReady() {
    $.ajax({
        url: "ready.php",
        success: function (data) {
            var response = jQuery.parseJSON(data);
            if (response["user_ready"] == 1 && response["num_ready"] != 3) {
                $(".timer-container").html('<p><strong>Waiting for players to get ready...</strong></p>');
            } else if (response["num_ready"] != 3) {
                var s = '<input type="hidden" name ="room_id" id="room_id" value=' + response["room_id"] + '><button type="button" class="btn btn-square" onclick="readyButton()" id="ready-btn">Ready</button>';
                $('.ready').html(s);
                $(".timer-container").html('<p><strong>When you are ready, click ready!</strong></p>');
            } else if (response["num_ready"] == 3) {
                clearInterval(ready_button_interval);
                $(".timer-container").load("timer.php");
            }
        },
        error: function () {
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
        success: function (data) {
            $("#ready-btn").remove();
        },
        error: function () {
            $("#error").html("Error on submitting data");
        }
    });
}

function voteButton() {
    var voted = $("input[name='voted_id']:checked").val();

    $.ajax({
        url: "vote_action.php",
        type: "POST",
        data: {
            voted: voted
        },
        success: function (data) {
            var response = jQuery.parseJSON(data);
            var s = "room.php?room_id=" + response["room_id"];
            window.location.href = s;
        },
        error: function () {
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
    var countdown_container = document.getElementById("countdown-container");
    var countdown = document.getElementById("countdown");
    if (count > 25) {
        countdown_container.style.backgroundColor = "#41B73C";
        countdown.innerHTML = "0" + "0" + ":" + count + "<span id='countdown-text'>seconds remaining</span>";
    } else if (count <= 25 && count >= 10) {
        countdown_container.style.backgroundColor = "orange";
        countdown.innerHTML = "0" + "0" + ":" + count + "<span id='countdown-text'>seconds remaining</span>";
    } else if (count < 10 && count >= 0) {
        countdown_container.style.backgroundColor = "#FF0000";
        countdown.innerHTML = "0" + "0" + ":0" + count + "<span id='countdown-text'>seconds remaining</span>";
    }
    if (count == -1) {
        cdpause();
        countdown_container.style.backgroundColor = "#f2f2f2";
        countdown.innerHTML = "";
    } else if (count == 0) {
        //           alert(count);
        $(".timer-container").load("timer.php");
        countdown_container.style.backgroundColor = "#f2f2f2";
        countdown.innerHTML = "";
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

$(document).ready(function () {
    scTop();
    checkReady();
    $(".player-info").load("player-info.php");
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
