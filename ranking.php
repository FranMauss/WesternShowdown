<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <link rel="icon" href="img/icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <?php

    extract($_POST);

    try {
        require ('connection.php');
    } catch (Throwable $t) {
        echo "--------------------";
        echo "Mensaje : " . $t->getMessage();
    }

    try {
        if ($conexion = mysqli_connect($servidor, $usuario, $pass, $bbdd)) {
            mysqli_query($conexion, "SET NAMES 'UTF8'");
            if (mysqli_select_db($conexion, $bbdd)) {
                $consultaJ1 = "SELECT * FROM ranking WHERE nombre = '$nameJForm'";
                $resultado = mysqli_query($conexion, $consultaJ1);
                $filaJ = mysqli_fetch_array($resultado);
                if (mysqli_num_rows($resultado) > 0) {
                    if ($filaJ['min_turnos'] < $turnsJ || $defeatJ == 1) {
                        $turnsJ = $filaJ['min_turnos'];
                    }
                    $victoryJ += $filaJ['victorias'];
                    $defeatJ += $filaJ['derrotas'];
                    $consultaJUpdate = "UPDATE `ranking` SET `victorias`= '$victoryJ', `derrotas`= '$defeatJ', `min_turnos`='$turnsJ' WHERE `nombre` = '$nameJForm'";
                    $queryJ = mysqli_query($conexion, $consultaJUpdate);

                } else {
                    if ($victoryJ == 1) {
                        $consultaJIns = "INSERT INTO `ranking` (`nombre`, `victorias`, `derrotas`, `min_turnos`) VALUES ('$nameJForm','$victoryJ','$defeatJ','$turnsJ')";
                    } else {
                        $consultaJIns = "INSERT INTO `ranking` (`nombre`, `victorias`, `derrotas`) VALUES ('$nameJForm','$victoryJ','$defeatJ')";
                    }

                    $queryJ = mysqli_query($conexion, $consultaJIns);
                }
                $consultaIA1 = "SELECT * FROM ranking WHERE nombre = '$nameIAForm'";
                $resultado = mysqli_query($conexion, $consultaIA1);
                $fila = mysqli_fetch_array($resultado);
                if (mysqli_num_rows($resultado) > 0) {
                    if ($fila['min_turnos'] < $turnsIA || $defeatIA == 1) {
                        $turnsIA = $fila['min_turnos'];
                    }
                    $victoryIA += $fila['victorias'];
                    $defeatIA += $fila['derrotas'];
                    $consultaIAUpdate = "UPDATE `ranking` SET `victorias`= '$victoryIA', `derrotas`= '$defeatIA', `min_turnos`='$turnsIA' WHERE `nombre` = '$nameIAForm'";
                    $queryIA = mysqli_query($conexion, $consultaIAUpdate);
                } else {
                    if ($victoryIA == 1) {
                        $consultaIAIns = "INSERT INTO `ranking` (`nombre`, `victorias`, `derrotas`, `min_turnos`) VALUES ('$nameIAForm','$victoryIA','$defeatIA','$turnsIA')";
                    } else {
                        $consultaIAIns = "INSERT INTO `ranking` (`nombre`, `victorias`, `derrotas`) VALUES ('$nameIAForm','$victoryIA','$defeatIA')";
                    }

                    $queryIA = mysqli_query($conexion, $consultaIAIns);
                }

                if ($queryJ && $queryIA) {
                    $html = "<div id='ranking'><p>Ranking</p>";
                    $html .= "<table><thead><tr><th>Nombre</th><th>Victorias</th><th>Derrotas</th><th>Victoria más rápida</th></tr></thead><tbody>";
                    $consultaTable = "SELECT * FROM `ranking` ORDER BY `victorias` DESC LIMIT 5";
                    $resultado = mysqli_query($conexion, $consultaTable);
                    while ($fila = mysqli_fetch_array($resultado)) {
                        $html .= "<tr><td>$fila[nombre]</td><td>$fila[victorias]</td><td>$fila[derrotas]</td><td>$fila[min_turnos] turno/s</td></tr>";
                    }
                    $html .= "</tbody></table>";
                    $html .= "<div id='reloadR'><span>Volver a jugar</span></div>";
                    $html .= "</div>";
                    echo $html;
                }

            }
            mysqli_close($conexion);
        }
    } catch (mysqli_sql_exception $mse) {
        echo "Número del error: " . $mse->getCode();
        echo "Mensaje del error: " . $mse->getMessage();
    }

    ?>
</body>
<script>
    document.getElementById('reloadR').addEventListener('click', function(){
        window.location.href = 'game.php';
    })
</script>
</html>