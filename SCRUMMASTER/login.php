<?php
include('../conexao/base_de_dados.php');

if (isset($_SESSION['id'])) {
    header("Location: /Proyectos/techrr/config/painel_config/painel.php");
    exit();
}

$sessionLifetime = 18000;
ini_set('session.gc_maxlifetime', $sessionLifetime);
ini_set('session.cookie_lifetime', $sessionLifetime);

if (isset($_POST['usuario']) || isset($_POST['senha'])) {
    if (strlen($_POST['usuario']) == 0) {
        echo "Preencha seu usuário!";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha!";
    } else {
        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM sistema_de_login WHERE usuario = '$usuario' LIMIT 1";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();

            if (password_verify($senha, $usuario['senha'])) {
                session_start();
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['usuario'] = $usuario['usuario'];

                header("Location: painel_config/painel.php");
                exit();
            }
        }
        echo '
            <div class="alert alert-danger text-center" role="alert">
                Falha ao logar! <b>Usuário ou senha incorretos.</b>
            </div>
            <script>
                reproducirSonidoNotificacion();
            </script>
        ';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://kit.fontawesome.com/a076d05399.css" rel="stylesheet">
    <title>Login</title>

    <style>
        /* Estilo do botão de som */
        #header-sonido {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 10;
        }
    </style>

    <script>
        function reproducirSonidoNotificacion() {
            var audio = document.getElementById('notificationSound');
            audio.play();
        }
    </script>
    <audio id="notificationSound" src="songs/sonido.mp3" preload="auto"></audio>
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <!-- Botão de som no canto superior esquerdo -->
    <header id="header-sonido">
        <button id="btn-toggle-sonido" onclick="toggleSonido()" class="btn btn-outline-secondary btn-sm">
            <i id="icono-sonido" class="fas fa-volume-up"></i> Som
        </button>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">             
                <div class="card shadow-lg rounded-4 p-4">
                    <div class="text-center mb-4">
                        <a href="../index.php">
                            <img src="../imagens-banners/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
                        </a>
                        <h2 class="mt-3">Acesse a Sua Conta</h2>
                    </div>
                    <form action="" method="post">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
                                <input type="text" name="usuario" required class="form-control" placeholder="Usuário" maxlength="20" 
                                       data-bs-toggle="tooltip" title="Máximo de 20 caracteres, sem caracteres especiais">
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text"><ion-icon name="key-outline"></ion-icon></span>
                                <input type="password" name="senha" required class="form-control" placeholder="Senha" maxlength="12" 
                                       data-bs-toggle="tooltip" title="Senha deve ter entre 6 e 12 caracteres, com letras e números">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" onclick="reproducirSonidoNotificacion()" class="btn btn-primary rounded-4">
                                Entrar <ion-icon name="log-in-outline"></ion-icon>
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <p>Não tem conta? <a href="../index.php" class="text-decoration-none">Crie uma aqui</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        // Inicializar tooltips do Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Configuração do som e do ícone de alternância
        const audio = document.getElementById('notificationSound');
        const iconoSonido = document.getElementById('icono-sonido');

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

        window.onload = () => audio.play();
    </script>
</body>
</html>
