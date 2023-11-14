window.onbeforeunload = function() {
    var data = new FormData();
    data.append('update', 'true');
    
    navigator.sendBeacon('../Posts/updateActivity.php'); // Utiliza sendBeacon para llamadas en background
};
function updateActivity() {
    $.ajax({
        url: '../Posts/updateActivity.php', // Asegúrate de que la ruta sea correcta
        method: 'POST'
    });
}