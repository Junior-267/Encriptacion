<?php
require_once '../config/crypto.php';
$texto = "Mi numero de telefono es 555-1234";
$cifrado = cifrarAES256($texto);
$descifrado = descifrarAES256($cifrado);

echo "Original: " . $texto . "<br>";
echo "Cifrado: " . $cifrado . "<br>";
echo "Descifrado: " . $descifrado . "<br>";
echo ($texto === $descifrado) ? "Estado: Exitoso" : "Estado: Fallido";
?>
