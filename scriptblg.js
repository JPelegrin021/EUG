    const loginBtn = document.getElementById("loginBtn");
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");
    const registerBtn = document.getElementById("registerBtn");
    const closeBtn = document.getElementById("closeBtn");
    const loginTB = document.getElementById("loginTB");
    const closeBtnR = document.getElementById("closeBtnR");

    loginModal.style.display = "none";
    registerModal.style.display= "none";

    loginBtn.addEventListener("click", () => {
      loginModal.style.display = "block";
      registerModal.style.display= "none";
    });

    loginTB.addEventListener("click", () => {
      loginModal.style.display = "block";
      registerModal.style.display= "none";
    });

    registerBtn.addEventListener("click", () => {
      loginModal.style.display = "none";
      registerModal.style.display= "block";
    });

    closeBtn.addEventListener("click", () => {
      loginModal.style.display = "none";
    });

    closeBtnR.addEventListener("click", () => {
      registerModal.style.display = "none";
    });

    window.addEventListener('load', async () => {
      try {
        const rawData = await fetch('post.php', {
          method: 'GET',
        });
        const data = await rawData.text();
        document.getElementById('posts-container').innerHTML = data;
      } catch(error) {
        console.error('Error al cargar los posts');
      }
        
    });
        // $.ajax({
        //     url: 'post.php', // Reemplaza esto con la ruta correcta
        //     method: 'GET',
        //     success: function (data) {
                
        //     },
        //     error: function (error) {
        //         console.error('Error al cargar los posts: ', error);
        //     }
        // });
    // })
  //   $(document).ready(function () {
  //     function cargarPosts() {
  //         $.ajax({
  //             url: 'post.php', // Reemplaza esto con la ruta correcta
  //             method: 'GET',
  //             success: function (data) {
  //                 $('#posts-container').html(data);
  //             },
  //             error: function (error) {
  //                 console.error('Error al cargar los posts: ', error);
  //             }
  //         });
  //     }
  
  //     cargarPosts();
  // });
  
