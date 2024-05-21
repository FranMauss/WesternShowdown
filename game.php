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
<script>


  document.getElementById('comoJugar').addEventListener('click', function () {
    document.getElementById('comoJugar').style.display = 'none';
  })

  document.getElementById('instrucciones').addEventListener('click', function () {
    document.getElementById('comoJugar').style.display = 'grid';

  })

  let victoryJ = 0;
  let victoryIA = 0;
  let defeatJ = 0;
  let defeatIA = 0;

  function fillForm() {
    document.getElementById('nameJForm').value = jugador.nombre;
    console.log(jugador.nombre)
    document.getElementById('nameIAForm').value = rival.nombre;
    console.log(rival.nombre)
    document.getElementById('turnsJ').value = turnsJ;
    document.getElementById('turnsIA').value = turnsIA;
    document.getElementById('victoryJ').value = victoryJ;
    document.getElementById('defeatJ').value = defeatJ;
    document.getElementById('victoryIA').value = victoryIA;
    document.getElementById('defeatIA').value = defeatIA;
  }

  document.getElementById('reloadV').addEventListener('click', function () {
    victoryJ = 1;
    defeatIA = 1;
    fillForm();
    document.getElementById('gameForm').submit();
  })

  document.getElementById('reloadD').addEventListener('click', function () {
    victoryIA = 1;
    defeatJ = 1;
    fillForm();
    document.getElementById('gameForm').submit();
  })

  function quienEmpieza() {
    let caraOCruz = Math.random();
    if (caraOCruz < 0.5) {
      return true;
    } else {
      return false;
    }
  }

  //Funciones de visualizacion de los cambios en la pantalla

  function visualizarDefensa() {
    if (jugador.defensa) {
      document.getElementById('defensaJugador').innerHTML = "<img class=defIcon src=img/defensa.jpg>"
    } else {
      document.getElementById('defensaJugador').innerHTML = ""
    }
    if (rival.defensa) {
      document.getElementById('defensaIA').innerHTML = "<img class=defIcon src=img/defensa.jpg>"
    } else {
      document.getElementById('defensaIA').innerHTML = ""
    }
  }

  function actualizarAcciones(player) {
    let acciones = "<div>";
    for (let x = 0; x < player.accionesEsteTurno; x++) {
      acciones += "<img class=bullet src=img/bullet.jpg>";
    }
    acciones += "</div>";
    return acciones;
  }

  function actualizarVidaJ() {
    let vida = "<div>";
    for (let x = 0; x < jugador.saludActual; x++) {
      vida += "<img class=corazon src=img/heart.jpg>";
    }
    for (let y = jugador.saludActual; y < jugador.saludMaxima; y++) {
      vida += "<img class=corazon src=img/emptyheart.jpg>";
    }
    vida += "</div>";
    return vida;
  }

  function actualizarVidaIA() {
    let vida = "<div>";
    for (let y = rival.saludActual; y < rival.saludMaxima; y++) {
      vida += "<img class=corazon src=img/emptyheart.jpg>";
    }
    for (let x = 0; x < rival.saludActual; x++) {
      vida += "<img class=corazon src=img/heart.jpg>";
    }
    vida += "</div>";
    return vida;
  }

  //Unimos todas las actualizaciones en una sola funcion para llamarlas a la vez

  function actualizarHUD() {
    document.getElementById('vidaJ').innerHTML = actualizarVidaJ();
    document.getElementById('vidaIA').innerHTML = actualizarVidaIA();
    visualizarDefensa();
    document.getElementById('accionesJugador').innerHTML = actualizarAcciones(jugador);
    document.getElementById('accionesIA').innerHTML = actualizarAcciones(rival);
  }

  // Mostrar la carta que juega la IA

  function mostrarFlotante(imagen) {
    let flotante = document.getElementById('flotante');
    flotante.innerHTML = "<img class=cartaFlotante src=" + imagen + "></div>";
    flotante.style.display = 'block';
    setTimeout(function () {
      flotante.style.display = 'none';
    }, 2500);
  }

  //Animaciones

  //animacion de los agujeros de bala y la curacion

  function mostrarAnimacionJ(imagen) {
    let animacion = document.getElementById('animacionJ');
    animacion.innerHTML = "<img class=animacion src=" + imagen + "></div>";
    animacion.offsetHeight;

    if (imagen == "img/healing.jpg") {
      animacion.querySelector('.animacion').classList.add('curacion')
      setTimeout(function () {
        animacion.querySelector('.animacion').style.opacity = '0';
        animacion.querySelector('.animacion').style.transform = 'translateY(-100%)';
      }, 1000);
    } else {
      animacion.querySelector('.animacion').classList.remove('curacion')
      animacion.querySelector('.animacion').style.opacity = '1'; // Aplica el efecto de fade in
      setTimeout(function () {
        animacion.querySelector('.animacion').style.opacity = '0'; // Aplica el efecto de fade out
      }, 1500);
    }
  }

  function mostrarAnimacionIA(imagen) {
    let animacion = document.getElementById('animacionIA');
    animacion.innerHTML = "<img class=animacion src=" + imagen + "></div>";
    animacion.offsetHeight;
    if (imagen == "img/healing.jpg") {
      animacion.querySelector('.animacion').classList.add('curacion')
      setTimeout(function () {
        animacion.querySelector('.animacion').style.opacity = '0';
        animacion.querySelector('.animacion').style.transform = 'translateY(-100%)';
      }, 1000);
    } else {
      animacion.querySelector('.animacion').classList.remove('curacion')
      animacion.querySelector('.animacion').style.opacity = '1'; // Aplica el efecto de fade in
      setTimeout(function () {
        animacion.querySelector('.animacion').style.opacity = '0'; // Aplica el efecto de fade out
      }, 1500);
    }
  }

  //animacion del vaquero disparando

  function mostrarDisparoJ() {
    let animacion = document.getElementById('disparoJ');
    let gif = new Image(); // Crear un nuevo objeto Image
    gif.src = "img/disparo.gif"; // Asignar la fuente del GIF
    gif.onload = function () { // Cuando la imagen se carga completamente
      animacion.innerHTML = "<img class=disparo src= img/disparo.gif ></div>"; // Mostrar el GIF en el DOM
      animacion.offsetHeight; // Forzar un reflow para que la animación se active correctamente
      animacion.querySelector('.disparo').style.opacity = '1'; // Aplicar el efecto de fade in
      setTimeout(function () {
        animacion.querySelector('.disparo').style.opacity = '0'; // Aplicar el efecto de fade out
      }, 2700);
    };
  }

  function mostrarDisparoIA() {
    let animacion = document.getElementById('disparoIA');
    let gif = new Image(); // Crear un nuevo objeto Image
    gif.src = "img/disparo.gif"; // Asignar la fuente del GIF
    gif.onload = function () { // Cuando la imagen se carga completamente
      animacion.innerHTML = "<img class=disparo src= img/disparoIA.gif ></div>"; // Mostrar el GIF en el DOM
      animacion.offsetHeight; // Forzar un reflow para que la animación se active correctamente
      animacion.querySelector('.disparo').style.opacity = '1'; // Aplicar el efecto de fade in
      setTimeout(function () {
        animacion.querySelector('.disparo').style.opacity = '0'; // Aplicar el efecto de fade out
      }, 2700);
    };

  }

  //Funciones de fin del juego

  //derrota

  function defeat() {
    document.getElementById('defeat-screen').style.display = 'block';
    document.getElementById('fondo').style.display = 'none';
    document.getElementById('defeatName').innerHTML = rival.nombre
    setTimeout(() => {
      document.getElementById('youDied').style.display = 'block';
    }, 3000);
  }

  //Victoria

  function victory() {
    document.getElementById('nombreVictoria').innerHTML = rival.nombre
    document.getElementById('fondo').style.animation = 'slideDown 2.5s ease';
    setTimeout(() => {
      document.getElementById('fondo').style.display = 'none';
      document.getElementById('victory-screen').style.display = 'flex';
    }, 2000);
  }

  //Logica turno del jugador

  let turnsJ = 0;

  function turnoJugador() {
    turnsJ++;
    document.getElementById("endTurn").style.display = 'block';
    jugador.accionesEsteTurno = jugador.accionesPorTurno;
    actualizarHUD()
    let numeroDeCartas = document.getElementById('manoJugador').childElementCount;
    let clickable = false;
    let robar = false;

    if (numeroDeCartas == 5) {
      clickable = true;
      robar = false;
    } else {
      clickable = false;
      robar = true;
      document.getElementById("flecha").style.display = 'block';
    }

    document.getElementById("baraja").addEventListener("click", function () {
      numeroDeCartas = document.getElementById('manoJugador').childElementCount;
      if (numeroDeCartas < 5 && robar) {
        let cartaDatos = baraja[Math.floor(Math.random() * baraja.length)];
        let nuevoElemento = document.createElement('img');
        nuevoElemento.setAttribute('class', 'carta');
        nuevoElemento.setAttribute('src', cartaDatos.img);

        // Agregar la animación solo al elemento recién creado
        nuevoElemento.style.animation = 'fadein 0.7s ease-in';

        document.getElementById("manoJugador").appendChild(nuevoElemento);

        numeroDeCartas = document.getElementById('manoJugador').childElementCount;
        if (numeroDeCartas == 5) {
          clickable = true;
          robar = false;
          document.getElementById("flecha").style.display = 'none';
        }
      }
    });

    $('#manoJugador').on('click', 'img', function () {
      if (clickable) {
        clickable = false;
        baraja.forEach(element => {
          if (element.img == $(this).attr('src')) {

            if (element.consumeAcciones && jugador.accionesEsteTurno <= 0) {
              document.getElementById('anuncio4').style.display = 'block';
              setTimeout(() => {
                document.getElementById('anuncio4').style.display = 'none';
              }, 5000);
              clickable = true;
              return; // Salir del bucle forEach si la carta consume acciones y el jugador no tiene acciones disponibles
            }
            element.jugar();
            if (element.consumeAcciones) {
              jugador.accion(-1); // Reducir el número de acciones disponibles si la carta consume acciones
            }

            $(this).animate({
              opacity: 0,
            }, 1000, function () {
              // Una vez completada la animación, elimina la imagen 
              $(this).remove();
              actualizarHUD();
            });
          }
        });
        setTimeout(() => {
          clickable = true;
        }, 3000);
      }
      document.getElementById("endTurn").addEventListener("click", function () {
        if (clickable) {
          document.getElementById("endTurn").style.display = 'none';
          clickable = false;
          return turnoIA();
        }
      });

    })


  }

  //Logica turno de la IA

  let turnoIAActivo = false;
  let turnsIA = 0;

  function turnoIA() {

    if (turnoIAActivo) return; // Salir si el turno de la IA ya está activo
    turnoIAActivo = true;
    turnsIA++;
    let turnoJug = false;
    rival.accionesEsteTurno = rival.accionesPorTurno;
    actualizarHUD();
    numCartas = document.getElementById('manoia').childElementCount;
    if (numCartas < 5) {
      let robarIA = setInterval(function () {
        let cartaDatos = baraja[Math.floor(Math.random() * baraja.length)];
        let nuevoElemento = document.createElement('img');
        nuevoElemento.setAttribute('class', 'carta');
        nuevoElemento.setAttribute('data-id', cartaDatos.id);
        nuevoElemento.setAttribute('src', 'img/dorso.jpg');

        // Agregar la animación solo al elemento recién creado
        nuevoElemento.style.animation = 'fadein 0.7s ease-in';

        document.getElementById("manoia").appendChild(nuevoElemento);

        numCartas = document.getElementById('manoia').childElementCount;
        if (numCartas == 5) {
          clearInterval(robarIA);
          jugarIA();
        }
      }, 1000);
    } else {
      jugarIA();
    }


    function removeCard(x) {
      let index = cartasEnManoIA.indexOf(x);
      console.log(index)
      let cartaEliminar = manoIACartas[index];
      console.log(cartaEliminar)
      if (index !== -1) {
        $(cartaEliminar).animate({
          opacity: 0,
        }, 1000, function () {
          console.log(manoIACartas);
          console.log(cartasEnManoIA);
          cartasEnManoIA.splice(index, 1);
          cartaEliminar.remove();
          refreshManoIA();
          actualizarHUD();
          console.log(manoIACartas);
          console.log(cartasEnManoIA);
        });

      }
    }

    function refreshManoIA() {
      cartasEnManoIA = [];
      manoIACartas = document.querySelectorAll('#manoia .carta');
      manoIACartas.forEach(carta => {
        cartasEnManoIA.push(parseInt(carta.getAttribute('data-id')));
      });
    }

    function jugarIA() {
      refreshManoIA()
      let intervaloIA = setInterval(function () {
        if (cartasEnManoIA.includes(7) && rival.saludActual < rival.saludMaxima) {
          rival.aumentarSalud(1);
          removeCard(7);
          mostrarFlotante("img/tequilashot.jpg")
          //img/tequilashot.jpg
        } else if (cartasEnManoIA.includes(3) && (!jugador.defensa || !cartasEnManoIA.includes(2))) {
          jugador.reducirSalud(1);
          removeCard(3);
          mostrarFlotante("img/quickshot.jpg")
          //img/quickshot.jpg
        } else if (cartasEnManoIA.includes(11) && !rival.defensa) {
          rival.activarDefensa();
          removeCard(11);
          mostrarFlotante("img/acubierto.jpg")
          //img/acubierto.jpg
        } else if (rival.accionesEsteTurno > 0) {
          if (cartasEnManoIA.includes(9) && !rival.defensa && rival.saludActual < rival.saludMaxima) {
            rival.activarDefensa();
            rival.aumentarSalud(1);
            rival.accion(-1);
            removeCard(9);
            mostrarFlotante("img/securesip.jpg")
            //img/securesip.jpg
          } else if (cartasEnManoIA.includes(8) && rival.saludActual <= rival.saludMaxima - 2) {
            rival.aumentarSalud(2);
            rival.accion(-1);
            removeCard(8);
            mostrarFlotante("img/whiskytriplex.jpg")
            //img/whiskytriplex.jpg
          } else if (cartasEnManoIA.includes(6) && (rival.saludActual < rival.saludMaxima || jugador.saludActual < 4)) {
            jugador.reducirSalud(1);
            rival.aumentarSalud(1);
            rival.accion(-1);
            removeCard(6);
            mostrarFlotante("img/wombocombo.jpg")

            //img/wombocombo.jpg
          } else if (cartasEnManoIA.includes(2) && (jugador.defensa || jugador.saludActual < 4)) {
            jugador.quitarDefensa()
            jugador.reducirSalud(1);
            rival.accion(-1);
            removeCard(2);
            mostrarFlotante("img/escopeta.jpg")

            //img/escopeta.jpg
          } else if (cartasEnManoIA.includes(1) && !rival.defensa) {
            revolver(jugador);
            rival.accion(-1);
            removeCard(1);
            mostrarFlotante("img/revolver.jpg")

            //img/revolver.jpg
          } else if (cartasEnManoIA.includes(5) && rival.saludActual > rival.saludMaxima / 2 && !jugador.defensa) {
            ruletaRusa(rival, jugador);
            rival.accion(-1);
            removeCard(5);
            mostrarFlotante("img/riskyplay.jpg")
            //img/riskyplay.jpg
          } else if (cartasEnManoIA.includes(4) && !jugador.defensa) {
            jugador.reducirSalud(2);
            rival.accion(-1);
            removeCard(4);
            mostrarFlotante("img/doubleshot.jpg")

            //img/doubleshot.jpg
          } else if (cartasEnManoIA.includes(10) && !rival.defensa) {
            rival.activarDefensa();
            jugador.reducirSalud(1);
            rival.accion(-1);
            removeCard(10);
            mostrarFlotante("img/fromthefence.jpg")
            //img/fromthefence.jpg
          } else {
            if (cartasEnManoIA.includes(2)) {
              jugador.quitarDefensa()
              jugador.reducirSalud(1);
              rival.accion(-1);
              removeCard(2);
              mostrarFlotante("img/escopeta.jpg")

            } else if (cartasEnManoIA.includes(10)) {
              rival.activarDefensa();
              jugador.reducirSalud(1);
              rival.accion(-1);
              removeCard(10);
              mostrarFlotante("img/fromthefence.jpg")

            } else if (cartasEnManoIA.includes(6)) {
              jugador.reducirSalud(1);
              rival.aumentarSalud(1);
              rival.accion(-1);
              removeCard(6);
              mostrarFlotante("img/wombocombo.jpg")

            } else if (cartasEnManoIA.includes(1)) {
              revolver(jugador);
              rival.accion(-1);
              removeCard(1);
              mostrarFlotante("img/revolver.jpg")

              //img/revolver.jpg
            } else {
              turnoIAActivo = false;
              clearInterval(intervaloIA);
              return turnoJugador()
            }
          }
        } else {
          turnoIAActivo = false;
          clearInterval(intervaloIA);
          return turnoJugador()
        }
      }, 5000);
    }

  }



  //de pantalla inicial se va a la mesa con las cartas
  document.getElementById("empezar").addEventListener("click", function () {
    document.getElementById("empezar").style.display = "none";
    document.getElementById("instrucciones").style.display = "none";
    document.getElementById("nombreIA").innerHTML = nombreia;
    const imagenInicio = document.getElementById("inicio");
    // Aplicamos la transformación de escala (zoom) y reducimos la opacidad
    imagenInicio.style.transform = "scale(1.5)";
    imagenInicio.style.opacity = "0";

    // Esperamos 2 segundos antes de ocultar la imagen de inicio y mostrar el fondo
    setTimeout(function () {
      document.getElementById("fondo").style.display = "grid";
      document.getElementById("inicio").style.display = "none";
    }, 2000);
    actualizarHUD()
    setTimeout(function () {
      if (quienEmpieza()) {
        turnoJugador();
      } else {
        turnoIA();
      }
    }, 3000);
  });
</script>

</html>