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
