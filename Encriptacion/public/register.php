<?php
session_start();
require_once '../config/database.php';
require_once '../config/crypto.php'; //Importar modulo de cifrado
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono'] ?? '');  //Captura de entrada del formulario
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
            // Hashear la contraseña, justo antes de mandar el usuario a la base de datos
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $telefono_cifrado = !empty($telefono) ? cifrarAES256($telefono) : null;

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, telefono_cifrado) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password, $telefono_cifrado])) {
                $success = '¡Registro exitoso!';
            } else {
                $error = 'Registro fallido. Por favor, intentelo nuevamente.';
            }
        }
    }
}
?>
