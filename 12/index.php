<?php
session_start();
$tituloPagina = 'Portada';

$contenidoPrincipal=<<<EOS
	<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require("includes/comun/plantilla.php");
?>