<?php
//Iniciar sesion - Guardar datos del usuario en $_SESSION
if ($user && password_verify($password , $user['password'])) {
  require_once '../config/crypto.php';
   //Generacion de un token pseudoaleatorio seguro
  $token_original = "SESION_" . bin2hex(random_bytes(16));
  // Cifrado asimétrico mediante clave pública
  $token_cifrado = cifrarRSA($token_original);
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['login_time'] = date('Y-m-d H:i:s');
  $_SESSION['token_rsa_cifrado'] = $token_cifrado;
  $_SESSION['token_rsa_descifrado'] = $token_descifrado;
 
  header('Location: dashboard.php');
  exit;
}
?>
