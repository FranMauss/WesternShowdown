// Se crea la clase jugador con los parametros y funciones necesarias
class Jugador {
  constructor(nombre) {
    this.nombre = nombre;
    this.saludMaxima = 8;
    this.saludActual = this.saludMaxima;
    this.accionesPorTurno = 2;
    this.accionesEsteTurno = this.accionesPorTurno;
    this.defensa = false;
    this.manoMaxima = 5;
  }

  // funcion de daño
  reducirSalud(valor) {
    if (this == rival) {
      mostrarDisparoJ();
      setTimeout(() => {
        if (valor == 1) {
          mostrarAnimacionIA("img/singlehole.jpg");
        } else if (valor == 2) {
          mostrarAnimacionIA("img/doublehole.jpg");
        } else if (valor == 3) {
          mostrarAnimacionIA("img/triplehole.jpg");
        }
      }, 1500);
    } else {
      mostrarDisparoIA();
      setTimeout(() => {
        if (valor == 1) {
          mostrarAnimacionJ("img/singlehole.jpg");
        } else if (valor == 2) {
          mostrarAnimacionJ("img/doublehole.jpg");
        } else if (valor == 3) {
          mostrarAnimacionJ("img/triplehole.jpg");
        }
      }, 1500);
    }

    if (this.defensa) {
      this.defensa = false;
    } else {
      this.saludActual -= valor;
      if (this.saludActual <= 0) {
        this.saludActual = 0;
        setTimeout(() => {
          if (this == jugador) {
            defeat();
          } else {
            victory();
          }
        }, 5000);
      }
    }
  }
  // funcion de cura
  aumentarSalud(valor) {
    this.saludActual += valor;
    if (this == rival) {
      mostrarAnimacionIA("img/healing.jpg");
    } else {
      mostrarAnimacionJ("img/healing.jpg");
    }
    if (this.saludActual > this.saludMaxima) {
      this.saludActual = this.saludMaxima;
      console.log(`${this.nombre}, no puedes superar el máximo de vida.`);
    }
  }
  activarDefensa() {
    this.defensa = true;
  }

  quitarDefensa() {
    this.defensa = false;
  }

  // funcion de acciones
  accion(valor) {
    this.accionesEsteTurno += valor;
  }
}

const nombresRival = [
  "Sergio, el Avionetas",
  "Jose David, Agente 47",
  "Abel, el Sin Barbilla",
  "Feirid, el Alfombras",
  "Yeimir, el Peruano",
  "Lyulin, el Mandarin",
  "Andres, el Morcillas",
  "Eugenio, el Almandrullos",
]; 

var random = Math.floor(Math.random() * nombresRival.length);
var nombreia = nombresRival[random];
let nombreJ = document.getElementById("nombreJugador").innerText;

const jugador = new Jugador(nombreJ);
const rival = new Jugador(nombreia);

class Carta {
  constructor(id, funciones, img, consumeAcciones) {
    this.id = id;
    this.funciones = funciones;
    this.img = img;
    this.consumeAcciones = consumeAcciones;
  }

  jugar() {
    this.funciones.forEach((funcion) => {
      funcion();
    });
    actualizarHUD();
  }
}

function ruletaRusa(x, y) {
  let caraOCruz = Math.random();
  if (caraOCruz < 0.5) {
    x.reducirSalud(1);
  } else {
    y.reducirSalud(3);
  }
}

function revolver(x){
  let random = Math.random();
  if (random < 0.5) {
    x.reducirSalud(1);
  } else if(random < 0.8){
    x.reducirSalud(2);
  } else {
    x.reducirSalud(3);
  }
}

const carta1 = new Carta(
  1,
  [() => revolver(rival)],
  "img/revolver.jpg",
  true // Esta carta consume acciones
);

const carta2 = new Carta(
  2,
  [() => rival.quitarDefensa(), () => rival.reducirSalud(1)],
  "img/escopeta.jpg",
  true // Esta carta consume acciones
);

const carta3 = new Carta(
  3,
  [() => rival.reducirSalud(1)],
  "img/quickshot.jpg",
  false // Esta carta no consume acciones
);

const carta4 = new Carta(
  4,
  [() => rival.reducirSalud(2)],
  "img/doubleshot.jpg",
  true
);

const carta5 = new Carta(
  5,
  [() => ruletaRusa(jugador, rival)],
  "img/riskyplay.jpg",
  true
);

const carta6 = new Carta(
  6,
  [() => jugador.aumentarSalud(1), () => rival.reducirSalud(1)],
  "img/wombocombo.jpg",
  true
);

const carta7 = new Carta(
  7,
  [() => jugador.aumentarSalud(1)],
  "img/tequilashot.jpg",
  false
);

const carta8 = new Carta(
  8,
  [() => jugador.aumentarSalud(2)],
  "img/whiskytriplex.jpg",
  true
);
const carta9 = new Carta(
  9,
  [() => jugador.aumentarSalud(1), () => jugador.activarDefensa()],
  "img/securesip.jpg",
  true
);
const carta10 = new Carta(
  10,
  [() => rival.reducirSalud(1), () => jugador.activarDefensa()],
  "img/fromthefence.jpg",
  true
);
const carta11 = new Carta(
  11,
  [() => jugador.activarDefensa()],
  "img/acubierto.jpg",
  false
);

const baraja = [
  carta1,
  carta2,
  carta3,
  carta4,
  carta5,
  carta6,
  carta7,
  carta8,
  carta9,
  carta10,
  carta11,
];

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
