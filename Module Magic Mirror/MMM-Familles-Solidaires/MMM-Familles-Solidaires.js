Module.register("MMM-Familles-Solidaires", {
    defaults: {
        content: "This is my test module.",
    },
    start: function () {
        this.count = 10;
    },
    getDom: function () {
        var element = document.createElement("div");
        element.className = "myContent";
        return element;
    },
    buildAMessage: function (message, position) {
        var newMessage = document.createElement("div");
        if (message.hasOwnProperty("param")) {
            newMessage.innerHTML = message["param"];
        } else {
            newMessage.innerHTML = message;
        }
        document.querySelector(position).style.display = "block";
        document.querySelector(position).innerHTML = "";
        document.querySelector(position).appendChild(newMessage);
        if (message.hasOwnProperty("timer")) {
            if (!isNaN(message["timer"]) && message["timer"] > 0) {
                setTimeout(function () {
                    document.querySelector(position).innerHTML = "";
                }, message["timer"]);
            }
        }
    },
    notificationReceived: function (notification, payload) {
        switch (notification) {
            case (notification = "SHOW_TBAR"):
                this.buildAMessage(payload, "div.region.top.bar > div.container");
                break;
            case (notification = "SHOW_TLEFT"):
                this.buildAMessage(payload, "div.region.top.left > div");
                break;
            case (notification = "SHOW_TCENTER"):
                this.buildAMessage(payload, "div.region.top.center > div");
                break;
            case (notification = "SHOW_TRIGHT"):
                this.buildAMessage(payload, "div.region.top.right > div");
                break;
            case (notification = "SHOW_UTHIRD"):
                this.buildAMessage(payload, "div.region.upper.third > div");
                break;
            case (notification = "SHOW_MCENTER"):
                this.buildAMessage(payload, "div.region.middle.center > div");
                break;
            case (notification = "SHOW_LTHIRD"):
                this.buildAMessage(payload, "div.region.lower.third > div");
                break;
            case (notification = "SHOW_BBAR"):
                this.buildAMessage(payload, "div.region.bottom.bar > div.container");
                break;
            case (notification = "SHOW_BLEFT"):
                this.buildAMessage(payload, "div.region.bottom.left > div");
                break;
            case (notification = "SHOW_BCENTER"):
                this.buildAMessage(payload, "div.region.bottom.center > div");
                break;
            case (notification = "SHOW_BRIGHT"):
                this.buildAMessage(payload, "div.region.bottom.right > div");
                break;
            default:
                break;
        }
    },
});
