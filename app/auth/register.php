<?php
include __DIR__ . '/../../persistence/database.php';
include __DIR__ . '/../../service/user_service.php';
include __DIR__ . '/../../entity/user_entity.php';

session_start();

$userService = new UserService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $senha = $_POST['password'];
  $cpf = $_POST['cpf'];

  $dbValue = $userService->getUserByEmail($email);

  if ($dbValue != null) {
    echo "Usuário já cadastrado.";
    return;
  }

  $user = new User();
  $user->fromArray($_POST);
  $user->setCreatedAt(new DateTime());
  $user->setRole("USER");

  $userService->createUser($user);

  header("Location: login.php");
}
?>

<h1>Cadastro</h1>
<form method="POST">
  Email: <input type="email" name="email" required><br>
  Senha: <input type="password" name="password" required><br>
  CPF: <input type="cpf" name="cpf" required><br>
  <button type="submit">Cadastrar</button>
</form>

<p>Ja tem uma conta? <a href="login.php">Acessar</a></p>