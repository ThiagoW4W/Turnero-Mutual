<?php
session_start();
//Si existe una sesion iniciada redirigo a menu
if (isset($_SESSION['documento'])) {
  header('Location: menu-principal.php');
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php
  include('headx.php');
  ?>
</head>

<body>

  <div class="container">
    <!--p id="titulo">INICIAR SESIÒN</p-->
    <p id="titulo" style="margin: 1px;">INICIAR SESIÓN</p>
    <form method="POST" id="formulario" action="loginx.php">

      <div class="input-group mx-auto">
        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Email" style="text-transform:uppercase; border-color: #2874A6; border-radius: 25px; text-align: center; margin: 5px;" autocomplete="off" maxlength="20">
      </div>

      <div class="input-group mx-auto">
        <input id="password" name="password" class="form-control .text-primary" type="password" placeholder="Contraseña" style="text-transform:uppercase; border-color: #2874A6; border-radius: 25px; text-align: center; margin: 5px;" autocomplete="off" maxlength="30">
      </div>
      <br>
      <div class="text-center">
        <button type="submit" id="botonIngresar" style="margin:1px">INGRESAR</button>
      </div>

    </form>

  </div>
</body>

</html>

<style type="text/css">
  * {
    font-family: 'Georgia', cursive;
  }

  .input-group {
    align-items: center;
    justify-content: center;
  }

  @media (max-width: 767px) {
    .input-group {
      width: 60%;
    }
  }

  a {
    color: #2874A6;
    font-weight: bold;
    font-size: 18px;
    /*font-family: 'Georgia', cursive;*/
  }

  a:hover {
    cursor: pointer;
    color: black;
  }

  p {
    /*color: #3391FF;*/
    text-align: center;
    /*font-size: 16px;*/
    /*text-transform: uppercase;*/
  }


  #botonIngresar {

    height: 40px;
    width: 150px;
    border: 2px solid;
    border-radius: 25px;
    font-size: 15px;
    /*background: #003366;*/
    background-color: #148F77;
    color: white;
    /*font-family: 'Georgia', cursive;*/
  }

  #botonIngresar:hover {
    background: white;
    /*color: #003366 !important;*/
    color: #148F77 !important;
  }

  #documento::placeholder,
  #clave::placeholder {
    /*color: #3391FF;*/
    /*color: #2874A6;*/
    text-align: center;
    padding-top: 30px;
    font-size: 15px;
    /*font-family: 'Georgia', cursive;*/
  }

  #titulo {
    /*color: #1E90FF;*/
    /*color: #2874A6;*/
    color: #003366;
    text-align: center;
    /*alineacion*/
    font-size: 30px;
    /*tamaño letra*/
    font-weight: 500;
    /*grosor letra*/
    /*font-family: 'Georgia', cursive;*/
  }

  #formulario {
    display: flex;
    flex-direction: column;
    align-items: center;

  }
</style>