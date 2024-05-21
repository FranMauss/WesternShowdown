<?php
try {
    require ('connection.php');
} catch (Throwable $t) {
    echo "--------------------";
    echo "Mensaje : " . $t->getMessage();
}

try {
    if ($conexion = mysqli_connect($servidor, $usuario, $pass, $bbdd)) {
        $_POST['nameR'] = mysqli_real_escape_string($conexion, $_POST['nameR']);
        $_POST['passR'] = mysqli_real_escape_string($conexion, $_POST['passR']);
        mysqli_query($conexion, "SET NAMES 'UTF8'");
        if (mysqli_select_db($conexion, $bbdd)) {
            $consulta = "SELECT * FROM usuarios WHERE nombre = '$_POST[nameR]'";
            $resultado = mysqli_query($conexion, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                header("location:index.php?mensaje=exist");
            } else {
                $consulta = "INSERT INTO `usuarios`(`nombre`, `pass`) VALUES ('{$_POST['nameR']}', '{$_POST['passR']}')";
                if (mysqli_query($conexion, $consulta)) {
                    session_start();
                    $_SESSION['usuario'] = $_POST['nameR'];
                    header("location:game.php");
                } else {
                    header("location:index.php?mensaje=error");
                }
            }
        }
    }
} catch (mysqli_sql_exception $mse) {
    echo "Número del error: " . $mse->getCode();
    echo "Mensaje del error: " . $mse->getMessage();
}
?>