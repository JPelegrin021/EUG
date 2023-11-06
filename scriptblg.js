    const loginBtn = document.getElementById("loginBtn");
    const loginModal = document.getElementById("loginModal");
    const closeBtn = document.getElementById("closeBtn");

    loginBtn.addEventListener("click", () => {
      loginModal.style.display = "block";
    });

    closeBtn.addEventListener("click", () => {
      loginModal.style.display = "none";
    });

    $(document).ready(function () {
      function cargarPosts() {
          $.ajax({
              url: 'post.php', // Reemplaza esto con la ruta correcta
              method: 'GET',
              success: function (data) {
                  $('#posts-container').html(data);
              },
              error: function (error) {
                  console.error('Error al cargar los posts: ', error);
              }
          });
      }
  
      cargarPosts();
  });
  
