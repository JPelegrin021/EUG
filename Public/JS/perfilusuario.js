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

function addLike(postCode) {
    fetch('../Posts/addLike.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'postCode=' + postCode
    })
    .then(response => response.text())
    .then(response => {
        const likeButton = document.querySelector('.like-btn[data-post-code="' + postCode + '"]');
        const likeCountSpan = document.querySelector('.like-count[data-post-code="' + postCode + '"]');

        if (likeButton && likeCountSpan) {
            let currentLikes = parseInt(likeCountSpan.textContent);
            if (isNaN(currentLikes)) currentLikes = 0;

            if (response.includes("agregado")) {
                // Like fue agregado
                likeButton.classList.add('liked');
                likeCountSpan.textContent = (currentLikes + 1) + ' likes';
            } else if (response.includes("eliminado")) {
                // Like fue eliminado
                likeButton.classList.remove('liked');
                likeCountSpan.textContent = (currentLikes - 1) + ' likes';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}