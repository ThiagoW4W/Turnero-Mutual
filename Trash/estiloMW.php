<style type="text/css">
                           /*GENERAL--------------------------------------------*/
  /*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }

body{
  background-image: url("imagenes/fondo2.jpg");
}

hr{
  border-color: #FFC947;
}

#datos{
  font-size: 14px;
}

#cajaDeBotones{
  margin: 0 auto;
  text-align: center;

}

.container{
   text-align: center;
}

#saludo{
  font-size: 15px; 
  color: #3A73A8; 
  text-align: left;
  margin-top: 2%;
}

#titulo{
  color: #0F4C75;
  text-align: center;
  font-size: 160%;
  font-weight: 15px;
}

#subtitulo{
  color: #0A1931;
  text-align: center; /*alineacion*/
  font-size: 15px;  /*tamaño letra*/
  font-weight: 300; /*grosor letra*/
}

#textoizq{
  text-align: left;
}

#iconos{
  height: 5%;
  width: 5%;
  margin-left: 2%;
}

#red{
  height: 5%;
  width: 5%;
  margin-right: 2%;
  margin-left: 2%;
}

#red:hover{
  transform: scale(1.1);
}

#advertencia{
  font-family: bold;
  font-size: 130%;
  color: #1B262C;
  text-align: center;
}

.boton{/*el boton es responsive y con un tamaño independiente al texto para que todos tengan un tamaño fijo*/
  font-size: 100%;
  color: #EFEFEF;
  border-color: #BBE1FA;
  background-color: #0F4C75;
  height: auto;
  width: 40vw;
  margin-bottom: 3%;
  margin-right: 2%;
  border-radius: 2vh;   /*uso vh para que el radio se base en la altura y se modifique cuando cambia el tamaño de los botones*/
}

.boton:hover{
  color: #0F4C75;
  background-color: #EFEFEF;
  transform: scale(1.1);
}
         /*NAVEGACION.PHP-------------------------------------------------*/
/*para pc*/
@media screen and (min-width: 1024px){  

#botonMenu{
  margin-right: 15%;
  border: 2px solid;
  border-radius: 2vh;
  font-size: 2vh;
}
#leyenda{
    font-size: 2.5vw;
}
#logonav{
  height: 20vh;
}

}

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ 

#botonMenu{
  margin-right: 2px;
  margin-bottom: 3px;
  border: 1px solid;
  border-radius: 2vh;
  font-size: 1.5vh;
}
#leyenda{
  font-size: 2vw;
}
#logonav{
  height: 10vh;
}
}

/*para celulares*/
@media screen and (max-width: 600px){  

#botonMenu{
  margin-right: 2px;
  margin-bottom: 3px;
  border: 1px solid;
  border-radius: 2vh;
  font-size: 1vh;
}
#leyenda{
  font-size: 3vw;
}
#logonav{
  height: 6vh;
}

} /*fin media queri*/


#leyenda{
  color: white;
  margin: 0%;       /* centra el texto en la barra de navegacion*/

}


#botonMenu{
  float:right;
  background-color: #3282B8;
  color: white;
  text-align: center;
  border-color: #EFEFEF;
  font-weight: bold;
  width: auto;
}

#botonMenu:hover{
  color: #0072BC;
  background-color:#EFEFEF;
  border-color: #3282B8;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}
#barra{
  display:flex;
  justify-content:space-between;
  align-items: center;
  
  background-image: url("imagenes/fondoBarra.png");
  color: EFEFEF;
  height:25vh;
  width: 100%;

}

#salir{
  text-decoration:none;
  color: white;
  font-size: 18px;
}


      /*ESTILO CAMBIAR CLAVE-------------------------------------------------------*/

/*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }

#clave{
  border-color: #2874A6; 
  border-radius: 25px; 
  text-align: center;
  margin:5px;
}
#confirmacion{
  border-color: #2874A6; 
  border-radius: 25px; 
  text-align: center;
  margin:5px;
}

#barra
#loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('imagenes/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}

.input-group-text{
  border: solid 1px #2874A6;
  background-color: white;
}
.input-group { 
  width: 35%;
}
a{
  color: #2874A6;
 
}
a:hover{
  cursor: pointer;
  color: black;
}

#contenedor{
  width: 750px;
  height: 550px;
  margin: 50px auto;
  background-color: white;
}
#container{
  display: flex;
}
#containerMenu{
  /*flex-basis: 33%;*/
}
#botonCambiar{
  background-color: #3282B8;
  height:40px; 
  width:180px;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
}
#botonCambiar{
  color: white;
  background-color: #185ADB!important ;
}
#botonCambiar:hover{
  background: #BBE1FA !important;
  color: #148F77 !important;
}

#botonVolver{
  margin: 0 auto;
  margin-bottom: 5px;
  height:90%; 
  width:20vh;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
  color: white;
  background-color: #062863;
  text-align: center ;
  float: right;
}
#botonVolver:hover{
  background: white;
  color: #062863 !important;
}

#clave::placeholder, #confirmacion::placeholder{
  text-align: center;
  padding-top: 30px;
  font-size: 15px;
}


#titulochico{
  color: #003366;
  text-align: center; /*alineacion*/
  font-size: 25px;  /*tamaño letra*/
  font-weight: 500; /*grosor letra*/
  margin:5px;
}

.input-groupchico { 
  width: 50%;
}

      /* ESTILO HISTORIALES */

/*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }
<style type="text/css">
h6{
  font-family: 'italic'; 
  color: #3A73A8;
  font-weight: normal;
}
#iconos{
  height: 5%;
  width: 5%;
  margin-left: 2%;
}

#fila{
  background-color: #1c4c96; 
  color: #EFEFEF; 
  font-weight: 200;
  font-family: 'italic';
  font-size: 130%;
}
#detalle{
  font-family: 'Verdana';
  color:black;
  font-size: 13px;
}
#fila1{
  border:none;
}
#tablaCarga{
  background-color: #3282B8;
}

#botonver{
  width: 90%;
  background-color: #3282B8;
  color: #EFEFEF;
  border: 2px solid;
  border-radius: 10px;
  border-color: #EFEFEF;
}

#botonver:hover{
  color: #0072BC;
  background-color:#EFEFEF;
  border-color: #3282B8;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}


      /*ESTILO ACTIVAR*/

/*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }

.form-control{
  text-transform:uppercase; 
  border-color: #BBE1FA; 
  border-radius: 25px; 
  text-align: center;
  margin:5px;
}

#loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('imagenes/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}

.input-group-text{
  border: solid 1px #2874A6;
  background-color: white;
}

.input-group { 
  width: 35%;
}

@media (max-width: 767px) {
   .input-group { 
    width: 60%;
    }
 }

a{
  color: #2874A6;
}

a:hover{
  cursor: pointer;
  color: black;
}

#contenedor{
  width: 750px;
  height: 550px;
  margin: 50px auto;
  background-color: white;
}

#botonActivar , #botonRecuperar , #botonReestablecer, #botonRegistrar, #botonVerificar{
  height:40px; 
  width:180px;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
  color: white;
  background-color: #1c4c96;
}

#botonActivar:hover, #botonRecuperar:hover, #botonReestablecer:hover, #botonRegistrar:hover, #botonVerificar:hover{
  background: white;
  color:#1c4c96 !important;
}
 #imagen{
    height: 25%;
    width: 25%;
    margin-top:3%;
  }
#usuario::placeholder, #documento::placeholder, #email::placeholder, #clave::placeholder, #confirmacion::placeholder{
  text-align: center;
  padding-top: 30px;
  font-size: 15px;
  margin: 2%;
  border-color: #BBE1FA;
}

    /* ACTUALIZACIONES */

/*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }
#alerta{
    color: #0072BC;
    text-align:center;
}
#tabla{
    text-align: center;
}
#mensaje{
    color: #0072BC;
    text-align: center;
}
barra


      /* BUSQUEDA */

/*para pc*/
@media screen and (min-width: 1024px){  
  }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }
#alerta2{
    color: black;
}


    /*ESTILO CREDENCIAL*/

/*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }
.btninter{
  border: 2px solid;
  border-color: #0072BC;
  transition: all 1s ease;
  position: relative;
  padding: 5px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px;      /*redondeo de las esquinas*/
  font-size: 17px;          /*tamaño letra*/
  color: white;             /*color letra*/
  width: 180px !important;  /*tamaño botones*/
  height: 40px !important;
  text-align: center;       /*alineacion de texto*/
  background: #0072BC;
}

.btninter:hover {
  background: white;
  color: #0072BC !important;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}

      /*ESTILO CUENTA CORRIENTE */

/*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }

#botonDeuda{
  float:right;
  background-color: #1B262C;
  color: white;
  border: 2px solid;
  border-radius: 10vh;
}

#mas:hover{
  title:'HOLA';
}

#detalle1{
  font-family: 'Verdana';
  color:red;
  font-size: 13px;
}
#detalle2{
  font-family: 'Verdana';
  color:#003366;
  font-weight: bold;
  font-size: 13px;
}

th {
    width: 200px;
    word-wrap: break-word;
}


#botonCuenta{
  margin: 0 auto;
  margin-bottom: 5px;
  height:90%; 
  width:20vh;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
  color: white;
  background-color: #062863;
  text-align: center ;
  float: right;
}
#botonCuenta:hover{
  background: white;
  color: #062863 !important;
}

    /* FORMULARIOS */

/*para pc*/
@media screen and (min-width: 1024px){    }

/*para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){ }

/*para celulares*/
@media screen and (max-width: 600px){   }
#pieDePaginaTramites{
  color: #EFEFEF;
  text-align: center;
  background-image: url(imagen/fondoBarra.png);  
}

#nomTramite{
  font-size: 300%;
}
.caja { 
font-size: 100%;
color: #1B262C; 
/*border-radius: 5vh;*/
border-top: 1vh solid #0072BC;
border-right: 1vh solid #0072BC;
border-bottom: 1vh solid #0072BC;
border-left: 1vh solid #0072BC;
padding: 5px;
}

#botonEnviar{
  float:left;
  margin-right: 10px;
  background-color: #3282B8;
  color: white;
  border: 2px solid;
  border-radius: 10px;
  text-align: center;
  border-color: #EFEFEF;
}

#botonEnviar:hover{
   color: #0072BC;
   background-color:#EFEFEF;
   border-color: #3282B8;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}

#loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('imagenes/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}

h6{
  font-family: 'italic'; 
  color: #3A73A8;
  font-weight: normal;
}

      /*RECUPERACION */


#documento::placeholder {
  text-align: center;
  padding-top: 30px;
  font-size: 15px;
}

#img-menu{
  height: 20vh;
  width: 20vh;
  border-radius: 10%;
  margin: 2%;
}
#img-menu:hover{
  transform: scale(1.1);
}

</style>