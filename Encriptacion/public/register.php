<?php
session_start();
require_once '../config/database.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $error = 'Todos los campos son requeridos';
  } elseif ($password !== $confirm_password) {
      $error = 'La contraseña registrada no coincide';
  } elseif (strlen($password) < 6) {
      $error = 'La contraseña debe tener un largo mínimo de 6 caracteres';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Formato de correo electronico invalido';
  } else {
      $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
  $stmt->execute([$username , $email]);
  if ($stmt->rowCount() > 0) {
$error = 'Nombre de usuario o email existentes';
  } else {
// Guardado temporal en texto plano (se corregira en el Paso 8)
  $stmt = $pdo->prepare("INSERT INTO users (username , email, password) VALUES (?, ?, ?)");
  if ($stmt->execute([$username , $email, $password])) {
    $success = '¡Registro exitoso!';
  } else {
    $error = 'Registro fallido. Por favor, intentelo nuevamente.';
        }
      }
    }
  }
?>
