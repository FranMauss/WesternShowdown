<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Western Showdown</title>
  <link rel="icon" href="img/icon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <link rel="stylesheet" href="styles.css" />
</head>

<body>

  <div class="container col-12" id="inicio">
    <img src="img/saloon_fuera.jpg" class="col-12" id="imagenInicio" />
    <span id="empezar">Empezar partida</span>
    <span id="instrucciones">Como jugar</span>
  </div>

  <div id="comoJugar">
    <div id="tituloIns">
      <p>Instrucciones</p>
    </div>
    <div id="introIns">
      <p>Bienvenido a Western Showdown, al principio del turno de cada jugador, este robara hasta tener 5 cartas.</p>
    </div>
    <div id="heartIns"><img src="img/heart.jpg"></div>
    <div id="textHeartIns">
      <p>Empezaras la partida con 8 puntos de salud y para ganar deberas reducir la salud del oponente a 0. Tu vida no puede ser superior a 8.</p>
    </div>
    <div id="shieldIns"><img src="img/defensa.jpg"></div>
    <div id="textShieldIns">
      <p>¡Ten cuidado! Si el rival tiene la defensa activada esto anulara la siguente perdida de salud. La defensa no se acumula.</p>
    </div>
    <div id="actionIns"><img src="img/bullet.jpg"></div>
    <div id="textActionIns">
      <p>Tendras 2 acciones por turno... Pero no todas las cartas consumen acciones</p>
    </div>
  </div>
  <?php
  session_start();
  ?>
  <div class="col-12" id="fondo">
    <div id="flotante"></div>
    <div class="tipsVaquero" id="anuncio4"><img src="img/anuncio4.jpg"></div>

    <div id="nombreJugador"><?php echo $_SESSION['usuario']; ?></div>
    <div id="vidaJ"></div>
    <div id="animacionJ"></div>
    <div id="disparoJ"></div>
    <div id="defensaJugador"></div>
    <div id="accionesJugador"></div>
    <div id="manoJugador"></div>

    <div id="nombreIA"></div>
    <div id="vidaIA"></div>
    <div id="animacionIA"></div>
    <div id="disparoIA"></div>
    <div id="manoia"></div>
    <div id="defensaIA"></div>
    <div id="accionesIA"></div>

    <img id="flecha" src="img/flecha.gif" />
    <img id="baraja" src="img/baraja.jpg" />
    <div id="endTurn"><span>Finalizar turno</span></div>


    <!-- <button onclick="victory()">Victoria</button>
    <button onclick="defeat()">Derrota</button> -->
  </div>
  <div id="defeat-screen">
    <div class="container" id="youDied"><img src="img/youdied.jpg">
      <p>Has sido derrotado por</p>
      <p id="defeatName"></p>
      <div id="reloadD"><span>Guardar y ver Ranking</span></div>
    </div>
  </div>
  <div id="victory-screen">
    <div id="victoryText">
      <div id="victoryGif"><img src="img/victoryDance.gif"></div>
      <p>Enhorabuena, has derrotado a</p>
      <p id="nombreVictoria"></p>
      <div id="reloadV"><span>Guardar y ver Ranking</span></div>
    </div>
  </div>
  <form id="gameForm" action="ranking.php" method="post">
    <input type="hidden" id="nameJForm" name="nameJForm">
    <input type="hidden" id="nameIAForm" name="nameIAForm">
    <input type="hidden" id="turnsJ" name="turnsJ">
    <input type="hidden" id="turnsIA" name="turnsIA">
    <input type="hidden" id="victoryJ" name="victoryJ">
    <input type="hidden" id="victoryIA" name="victoryIA">
    <input type="hidden" id="defeatJ" name="defeatJ">
    <input type="hidden" id="defeatIA" name="defeatIA">
  </form>
</body>

<script src="script.js"></script>

</html>