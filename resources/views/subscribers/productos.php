<?php 
session_start(); //Inicio sesion 
if(isset($_POST['nombre'])){ 
$nombre = $_POST['nombre']; 
$_SESSION['usuario'] = $nombre; //Guardo el nombre del usuario en sesion 
session_register('pedido'); 
}
if(isset($_POST['agregar'])){ //Si se envió el primer formulario 
$claves = array_keys($_POST); 
$producto = $claves[1]; 
if(!is_array($_SESSION['pedido'])) //Si no es un array 
{
$_SESSION['pedido'] = array();
}
if(array_key_exists("$producto",$_SESSION['pedido'])){ 
$cantidad = $_SESSION['pedido']["$producto"]; 
$_SESSION['pedido']["$producto"] = ++$cantidad; 
} 
else { 
$_SESSION['pedido']["$producto"] = 1; 
} 
} 
if(isset($_GET['quitar'])){ //Si se envió el segundo formulario 
$claves = array_keys($_GET); 
$producto = $claves[1]; 
unset($_SESSION['pedido'][$producto]); //Eliminar la posicion del arreglo 
} echo "Bienvenido : ".$_SESSION['usuario'];
?> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head> 
<body> 
<form action="productos.php" method="post"> 
<input type="hidden" name="agregar"> 
<table border="1"> 
<tr> 
<td width="150"> 
Producto: <b>TV</b><br> 
Descripcion: <b>31"</b><br> 
Precio: <b>1500000</b><br> 
<input type="submit" name="TV" id="button" value="Añadir al carrito">
</td> 
<td width="150"> 
Producto: <b>DVD</b><br>
Descripcion: <b>Negro</b><br> 
Precio: <b>200000</b><br> 
<input type="submit" name="DVD" id="button2" value="Añadir al carrito">
</td> 
<td width="150"> 
Producto: <b>MP4</b><br> 
Descripcion: <b>4GB</b><br> 
Precio: <b>150000</b><br> 
<input type="submit" name="MP4" id="button3" value="Añadir al carrito">
</td> 
</tr> 
<tr> 
<td> 
Producto: <b>Laptop</b><br> 
Descripcion: <b>12"</b><br> 
Precio: <b>1500000</b><br> 
<input type="submit" name="Laptop" id="button3" value="Añadir al carrito">
</td> <td> 
Producto: <b>MP3</b><br> 
Descripcion: <b>2GB</b><br> 
Precio: <b>100000</b><br> 
<input type="submit" name="MP3" id="button3" value="Añadir al carrito">
</td> 
<td> 
Producto: <b>Cámara</b><br> 
Descripcion: <b>12Mpx</b><br> 
Precio: <b>250000</b><br> 
<input type="submit" name="Cámara" id="button3" value="Añadir al carrito">
</td> 
</tr> 
<tr> 
<td> 
Producto: <b>Celular</b><br> 
Descripcion: <b>Negro</b><br> 
Precio: <b>200000</b><br> 
<input type="submit" name="Celular" id="button3" value="Añadir al carrito">
</td> 
<td> 
Producto: <b>PSP</b><br> 
Descripcion: <b>Gris</b><br> 
Precio: <b>500000</b><br> 
<input type="submit" name="PSP" id="button3" value="Añadir al carrito">
</td> 
<td> 
Producto: <b>Impresora</b><br> 
Descripcion: <b>Multifuncional</b><br> 
Precio: <b>300000</b><br> 
<input type="submit" name="Impresora" id="button3" value="Añadir al carrito">
</td> 
</tr> 
</table> 
</form> 
<form action="productos.php" method="get"> 
<h1>En el carrito de compras tiene los siguientes productos</h1> 
<input type="hidden" name="quitar"> 
<?php 
if(!empty($_SESSION['pedido'])){ //Si hay productos en el carrito
foreach($_SESSION['pedido'] as $prod => $unidades) { 
echo "$unidades unidades del producto $prod"; 
echo "<input type='Submit' name='$prod' value='Quitar'><br>"; } 
?> 
</form> 
<form action="confirmar.php" method="post"> 
<input type='Submit' name='Comprar' value="Confirmar compra"> 
</form> 
<?php 
} 
?> 
</body> 
</html>