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

function openEditModal(code, title, resume, content, image) {
  document.getElementById('editPostId').value = code;
  document.getElementById('editTitulo').value = title;
  document.getElementById('editResumen').value = resume;
  document.getElementById('editContenido').value = content;
  document.getElementById('editImagenActual').value = image;

  document.getElementById('editPostModal').style.display = 'block';
}

  
  // Cierra el modal si se hace clic en el botón cerrar o fuera del modal
  function closeEditModal() {
    document.getElementById('editPostModal').style.display = 'none';
  }
  
  // Cierra el modal si se hace clic fuera de él
  window.addEventListener('click', function(event) {
    var modal = document.getElementById('editPostModal');
    if (event.target == modal) {
      closeEditModal();
    }
  });

  // AdminPanel.js
function changeAdminStatus(userId, isAdmin) {
    // Aquí usamos Fetch API para enviar los datos al servidor
    fetch('../AdminUsers/UpdateUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `userId=${userId}&isAdmin=${isAdmin}`
    })
    .then(response => response.text())
    .then(data => {
        // Aquí puedes manejar la respuesta del servidor
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

  