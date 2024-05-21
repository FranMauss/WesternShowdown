<?php
try {
    require ('connection.php');
} catch (Throwable $t) {
    echo "--------------------";
    echo "Mensaje : " . $t->getMessage();
}
try {
    if ($conexion = mysqli_connect($servidor, $usuario, $pass, $bbdd)) {
        $_POST['nombre'] = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $_POST['pass'] = mysqli_real_escape_string($conexion, $_POST['pass']);
        mysqli_query($conexion, "SET NAMES 'UTF8'");
        if (mysqli_select_db($conexion, $bbdd)) {
            $consulta = "SELECT * FROM usuarios WHERE nombre = '$_POST[nombre]' AND pass = '$_POST[pass]'";
            $resultado = mysqli_query($conexion, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                session_start();
                $_SESSION['usuario'] = $_POST["nombre"];
                $_SESSION['logged'] = true;
                header("location:game.php");
            } else {
                header("location:index.php?mensaje=error");
            }
        }
    }
} catch (mysqli_sql_exception $mse) {
    echo "Número del error: " . $mse->getCode();
    echo "Mensaje del error: " . $mse->getMessage();
}
?>