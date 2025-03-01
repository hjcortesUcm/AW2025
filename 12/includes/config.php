<?php

define('BD_HOST', 'localhost');
define('BD_NAME', 'aw_c');
define('BD_USER', 'aw_c');
define('BD_PASS', 'aw_c');

$BD = null;

function getConexionBD() 
{
  global $BD;
  
  if (!$BD) 
  {
    $BD = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);
    
    if ( $BD->connect_errno ) 
    {
      echo "Error de conexión a la BD: (" . $BD->connect_errno . ") " . $BD->connect_error;
      exit();
    }
  }

  return $BD;
}

?>