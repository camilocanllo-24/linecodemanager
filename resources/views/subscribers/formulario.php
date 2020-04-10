<?php
session_start();
session_destroy();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Bienvenido a la tienda</h1>
<form action="productos.php" method="post">
Ingrese su nombre<input name="nombre" type="text">
<input name="ingresar" type="Submit" value="ingresar">
</form>
</body>
</html>