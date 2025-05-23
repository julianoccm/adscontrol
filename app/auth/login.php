<?php
include __DIR__ . '/../../persistence/database.php';
include __DIR__ . '/../../service/user_service.php';
include __DIR__ . '/../../entity/user_entity.php';

session_start();

$userService = new UserService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  $dbValue = $userService->getUserByEmail($email);

  if ($dbValue == null) {
    echo "Usuário não encontrado.";
    return;
  }

  $user = new User();
  $user->fromArray($dbValue);

  if ($userService->verifyPassword($user, $senha)) {
    $_SESSION['user'] = $user;

    if ($user->isAdmin()) {
      header("Location: ../admin.php");
    } else {
      header("Location: ../user.php");
    }
  } else {
    echo "Credenciais de acesso inválidas.";
  }
}
?>

<h1>Login</h1>
<form method="POST">
  Email: <input type="email" name="email" required><br>
  Senha: <input type="password" name="senha" required><br>
  <button type="submit">Entrar</button>
</form>

<p>Não tem uma conta? <a href="register.php">Registrar</a></p>