<?php

require('layout/header.php');

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/css_index.css">
    <title>Scrum Master</title>
</head>
<body>
    <section class="menu">
        <div class="div1_menu">

            <button id="btn-toggle-sonido" onclick="toggleSonido()">
            <i id="icono-sonido" class="fas fa-volume-up"></i>

            <a href="login_or_registrate.php">
                <div class="div2_menu">
                    <h1>INICIAR</h1>
                </div>
            </a>
        </div>
    </section>


    <audio id="sonido-iniciar" src="songs/sonido.mp3" preload="auto"></audio>

    <script> 
        // Variables de referencia al elemento de audio y al icono
        const audio = document.getElementById('sonido-iniciar');
        const iconoSonido = document.getElementById('icono-sonido');

        // Función para alternar entre reproducir y pausar el sonido
        function toggleSonido() {
            if (audio.paused) {
                audio.play();
                iconoSonido.classList.remove('fa-volume-mute');
                iconoSonido.classList.add('fa-volume-up');
            } else {
                audio.pause();
                iconoSonido.classList.remove('fa-volume-up');
                iconoSonido.classList.add('fa-volume-mute');
            }
        }

        // Reproduce el sonido al cargar la página
        window.onload = () => audio.play();
    </script>


</body>
</html>
