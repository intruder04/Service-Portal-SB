$(document).ready(function() {
    return setInterval(function () {
        var date = new Date();
       if (date.getSeconds() === 0) {
            $("#refreshButton").trigger("click");
        }
    }, 1000);
});

