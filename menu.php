<?php

session_start();



require("conexion.php");
$db = new BaseDatos();


if ($db->conectar()) {



?>


  <!DOCTYPE html>
  <html lang="es">
  <?php
  

  $usuario = $_SESSION['usuario'];
  $provincia = $usuario['provincia'];
  $name = $usuario['nombre']; 
  echo "HOLA: ". $name;
  include('head.php');
  include('navegacion.php');

  ?>

  <body>
    <div class="container">

      <hr />
      <p id="titulo">MENU</p>
      <hr />
      <!-- Para computadora -->
      <!--div class="d-none d-sm-none d-md-block"-->
      <div class="container">
        <div id="containerMenu">

          <!--<a href="formulario_becas.php"><img id="img-menu" src="imagenes/InscripcionBeca.gif"></a> -->

          <!--Lo de acá arriba ^^^^^^ se descomenta el 1ro de abril y cuando termina la inscripción a becas se vuelve a comentar.-->
          <?php
          if ($provincia == 'neuquen') {
          ?>
            <a href="turnero.php"><img id="img-menu" src="Image/turnos.png"></a>
          <?php
          }
          ?>
          <a href="/turnero/Admin/admin.php"><img id="img-menu" src="Image/check.png"></a>
          <a href="credencial.php"><img id="img-menu" src="imagenes/credencial2.gif"></a>
          <a href="datos-personales.php"><img id="img-menu" src="imagenes/datos-personales.gif"></a>
          <a href="cuenta-corriente.php"><img id="img-menu" src="imagenes/cuenta-corriente.gif"></a>


          <!--Al sacar el comentario de Becas, se va a descuadrar todo. Mover el <a> de tramites al container de abajo para que se acomode. Cuando termine se vuelve a su lugar y se acomoda todo.-->


          <!--button type="button" class="btn boton" onclick="window.location='datos-personales.php'">DATOS PERSONALES</button>
        <button type="button" class="btn boton" onclick="window.location='cuenta-corriente.php'">CUENTA CORRIENTE</button>
        <button type="button" class="btn boton" onclick="window.location='tramites.php'">TRAMITES</button-->
        </div>
        <br />
        <div id="containerMenu">
          <a href="tramites.php"><img id="img-menu" src="imagenes/tramites.gif"></a>
          <a href="facturas.php"><img id="img-menu" src="imagenes/recibos.gif"></a>
          <!--a href="ver-ejercicios.php">
          <img id="img-menu" src="imagenes/ejercicios-economicos.gif" width="225" height="225" HSPACE="10" VSPACE="10">
        </a-->
          <a href="contactos.php"><img id="img-menu" src="imagenes/contactos.gif"></a>
          <a href="cuenta.php"><img id="img-menu" src="imagenes/mi-cuenta.gif"></a>
          <!--a href="notificaciones.php"><img id="img-menu" src="imagenes/notificaciones.gif"></a-->


          <!--button type="button" class="btn boton" onclick="window.location='ver-facturas.php'">FACTURAS</button>
        <button type="button" class="btn boton" onclick="window.location='cuenta.php'">MI CUENTA</button>
        <button type="button" class="btn boton" onclick="window.location='mensajes.php'">MENSAJES</button-->
        </div>
      </div>
      <br>
      <br>
    </div>

    </div>
  </body>

  </html>


<?php
} ?>