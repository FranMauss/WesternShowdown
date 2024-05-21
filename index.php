<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="img/icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['logged'])) {
        if ($_SESSION['logged']) {
            session_destroy();
        }
    }

    if (isset($_GET['mensaje'])) {
        if ($_GET['mensaje'] == 'exist') { ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById('anuncio3').style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('anuncio3').style.display = 'none';
                    }, 5000);
                });
            </script>
            <?php
        }
    }
    ?>
    <div class="col-12" id="cartel">
        <div class="tipsVaquero" id="anuncio"><img src="img/anuncio.jpg"></div>
        <div class="tipsVaquero" id="anuncio2"><img src="img/anuncio2.jpg"></div>
        <div class="tipsVaquero" id="anuncio3"><img src="img/anuncio3.jpg"></div>
        <div id="requestName">
            <p>Introduce tu nombre</p>
        </div>
        <div id="inputName"><input id="nombre" type="text" maxlength="15" placeholder="Nombre"></div>
        <div id="inputPass"><input id="pass" type="password" maxlength="12" placeholder="Password"></div>
        <div id="submit"><img src="img/sheriff.jpg" title="Enviar"></div>
        <div id="goToRegister"><span>¿Eres nuevo en este condado?</span></div>
    </div>
    <form action="validation.php" id="formLogin" method="post">
        <input type="hidden" id="nameForm" name="nombre">
        <input type="hidden" id="passForm" name="pass">
    </form>
    <div class="col-12" id="contrato">
        <form action="register.php" id="registerForm" method="post">
            <input id="nombreRegistro" type="text" name="nameR" maxlength="15" placeholder="Nombre">
            <input id="passRegistro" type="password" name="passR" maxlength="12" id="passR" placeholder="Contraseña">
            <input id="passConfirm" type="password" maxlength="12" id="confirmPassR" placeholder="Confirma Contraseña">
            <p id="firmar">Firmar:</p>
            <img id="imgRegistro" src="img/pluma.jpg" title="Firmar">
        </form>
    </div>
</body>
<script>
    document.getElementById('goToRegister').addEventListener('click', function () {
        document.getElementById('cartel').style.display = 'none';
        document.getElementById('contrato').style.display = 'grid';
    })

    document.getElementById('submit').addEventListener('click', function () {
        let nombreInput = document.getElementById("nombre").value;
        let passInput = document.getElementById("pass").value;
        if (nombreInput.trim() === "") {
            document.getElementById('anuncio').style.display = 'block';
            setTimeout(() => {
                document.getElementById('anuncio').style.display = 'none';
            }, 5000);
        } else if (passInput.trim() === "") {
            document.getElementById('anuncio2').style.display = 'block';
            setTimeout(() => {
                document.getElementById('anuncio2').style.display = 'none';
            }, 5000);
        } else {
            document.getElementById('nameForm').value = nombreInput;
            document.getElementById('passForm').value = passInput;
            document.getElementById('formLogin').submit();
        }
    })

    document.getElementById('imgRegistro').addEventListener('click', function () {
        const nombre = document.getElementById('nombreRegistro').value.trim();
        const pass = document.getElementById('passRegistro').value.trim();
        const confirmPass = document.getElementById('passConfirm').value.trim();
        if (nombre === "" || pass === "" || confirmPass === "") {
            alert('Ningun campo puede estar vacío');
        } else if (nombre.length < 3) {
            alert('El nombre debe tener al menos 3 caracteres');
        } else if (pass.length < 8 || confirmPass.length < 8) {
            alert('La contraseña debe tener un mínimo de 8 caracteres');
        } else if (pass !== confirmPass) {
            alert('La contraseña no coincide en los dos campos');
        } else {
            document.getElementById('registerForm').submit();
        }
    })
</script>

</html>