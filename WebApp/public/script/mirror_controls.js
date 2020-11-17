$("#alertSend").on("click", function (e) {
    e.preventDefault();
    let alertTimer = 2000;
    let alertToSend = $("#alertInput").val();
    if ($("#alertTimer").val() !== "" && !isNaN($("#alertTimer").val())) {
        alertTimer = $("#alertTimer").val();
    }
    alertTimer = Number(alertTimer);
    $.ajax({
        url: "http://192.168.1.216:8080/api/module/alert/showalert?message=" +
            alertToSend +
            '&timer=' +
            alertTimer +
            '&apiKey=testkey',
        type: "GET",
        error: function () {
            $("#logEle").html("Error sending message, try again.");
        },
        success: function () {
            $("#logEle").html("Message sent.");
        },
    });
});

$("#messageSend").on("click", function (e) {
    e.preventDefault();
    // Replace ? with %3F to avoid URL issues
    let messageToSend = $("#messageInput").val().replace(/[?]/g, "%3F");
    // If input field was left empty, send a single space to clear display
    if (messageToSend == "") {
        messageToSend = " ";
    }
    // Clear input field
    $("#messageInput").val("");
    $.ajax({
        url:
            "http://192.168.1.216:8080/api/notification/SHOW_" +
            $("#position").val() +
            "/" +
            messageToSend +
            "?apiKey=testkey&timer=" +
            $("#displayDuration").val(),
        type: "GET",
        error: function () {
            $("#logEle").html("Error sending message, try again.");
        },
        success: function () {
            $("#logEle").html("Message sent.");
        },
    });
});

$("#messageDelete").on("click", function (e) {
    e.preventDefault();
    $.ajax({
        url: "http://192.168.1.216:8080/api/notification/SHOW_" + $("#position").val() + "/ ?apiKey=testkey",
        type: "GET",
        error: function () {
            $("#logEle").html("Error sending message, try again.");
        },
        success: function () {
            $("#logEle").html("Message sent.");
        },
    });
});