<?php
require "conexion.php";
require "prueba.html";
?>

<html>
    <body>
        <p id="pancho"></p>
    </body>
    
</html>
<script>
let html = document.getElementById("myP").innerHTML;
document.getElementById("demo").innerHTML = html;
</script>

<?php
?>