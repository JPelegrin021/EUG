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

// Llama a updateActivity cuando se hace clic en una imagen
$('.divImg img').click(function() {
    updateActivity();
});

// También puedes llamar a updateActivity en otros eventos, como al abrir un modal
$('#editModal').on('show.bs.modal', function (e) {
    updateActivity();
});

// Y otros eventos que consideres relevantes

function openEditModal(postCode) {
  fetch('../Posts/getPostsDetails.php?postCode=' + postCode)
  .then(response => {
      console.log(response); // Mover console.log aquí
      return response.json();
  })
  .then(data => {
      if (data && Object.keys(data).length > 0) {
          document.getElementById('editPostId').value = postCode;
          document.getElementById('editTitle').value = data.Title;
          document.getElementById('editSummary').value = data.Resume;
          document.getElementById('editModal').style.display = 'block';
      } else {
          console.error('No se pudo cargar el post', data);
      }
  })
  .catch(error => console.error('Error:', error));
}
document.addEventListener('DOMContentLoaded', function() {
  // Código para manejar los modales de inicio de sesión y registro
  const loginModal = document.getElementById("loginModal");
  const registerModal = document.getElementById("registerModal");
  const closeBtn = document.getElementById("closeBtn");
  const closeBtnR = document.getElementById("closeBtnR");

  loginModal && (loginModal.style.display = "none");
  registerModal && (registerModal.style.display= "none");

  const loginBtn = document.getElementById("loginBtn");
  loginBtn && loginBtn.addEventListener("click", () => {
      loginModal.style.display = "block";
      registerModal && (registerModal.style.display= "none");
  });

  const loginTB = document.getElementById("loginTB");
  loginTB && loginTB.addEventListener("click", () => {
      loginModal.style.display = "block";
      registerModal && (registerModal.style.display= "none");
  });

  const registerBtn = document.getElementById("registerBtn");
  registerBtn && registerBtn.addEventListener("click", () => {
      loginModal && (loginModal.style.display = "none");
      registerModal.style.display= "block";
  });

  closeBtn && closeBtn.addEventListener("click", () => {
      loginModal.style.display = "none";
  });

  closeBtnR && closeBtnR.addEventListener("click", () => {
      registerModal.style.display = "none";
  });

  // Código para manejar la carga de posts (si es necesario)
  // ...

  // Cerrar el modal de edición
  const editPostForm = document.getElementById('editPostForm');
  editPostForm && editPostForm.addEventListener('submit', function(event) {
      event.preventDefault();
  
      const postId = document.getElementById('editPostId').value;
      const title = document.getElementById('editTitle').value;
      const summary = document.getElementById('editSummary').value;
  
      fetch('../Posts/UpdatePosts.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'postId=' + encodeURIComponent(postId) + 
                '&title=' + encodeURIComponent(title) + 
                '&summary=' + encodeURIComponent(summary)
      })
      .then(response => response.text())
      .then(response => {
          console.log(response);
          document.getElementById('editModal').style.display = 'none';
          // Introduce un retraso antes de recargar la página
          setTimeout(() => {
              location.reload();
          }, 2000); // 2000 milisegundos = 2 segundos
      })
      .catch(error => console.error('Error:', error));
  });


  
});
function openModal(title, imageSrc, content) {
  document.getElementById('postTitle').textContent = title;
  document.getElementById('postImage').src = imageSrc;
  document.getElementById('postContent').textContent = content;
  document.getElementById('postModal').style.display = 'block';
}

function closeModal() {
  document.getElementById('postModal').style.display = 'none';
}

    