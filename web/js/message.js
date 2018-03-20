if (!window.Notification) {
    //alert("Извините, но ваш браузер не поддерживает уведомления");
} else {
    Notification.requestPermission(
        function(p) {
            if (p === "denied") {
                //alert("Вы отклонили уведомление");
            } else if (p === "granted") {
                //  alert("Вы приняли уведомление");
            }
        }
    );
}

function sendNotification(title, options) {
    if (Notification.permission === "granted") {
        var audio = new Audio('/sound/arpeggio.mp3');
        audio.play();
        var notification = new Notification(title, options);
    }
};
//setTimeout("sendNotification('Автоинформирование',{body: 'На вашу РГ поступил запрос SD3216547',icon: 'img/icon.png',dir: 'auto'})", 10000);
// setInterval("sendNotification('Автоинформирование',{body: 'На вашу группу поступил запрос SD3216547',dir: 'auto'})",8000);