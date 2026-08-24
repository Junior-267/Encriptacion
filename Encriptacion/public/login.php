Iniciar sesion - Guardar datos del usuario en $_SESSION
if ($user && password_verify($password , $user['password'])) {
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['login_time'] = date('Y-m-d H:i:s');
header('Location: dashboard.php');
exit;
}
