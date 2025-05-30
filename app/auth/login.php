<?php
include __DIR__ . '/../../persistence/database.php';
include __DIR__ . '/../../service/user_service.php';
include __DIR__ . '/../../entity/user_entity.php';

session_start();

$userService = new UserService();
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  $dbValue = $userService->getUserByEmail($email);

  if ($dbValue == null) {
    $erro = "Usuário não encontrado.";
  } else {
    $user = new User();
    $user->fromArray($dbValue);

    if ($userService->verifyPassword($user, $senha)) {
      $_SESSION['user'] = $user;

      if ($user->isAdmin()) {
        header("Location: ../admin.php");
      } else {
        header("Location: ../user.php");
      }
      exit;
    } else {
      $erro = "Credenciais de acesso inválidas.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login - AdsControl</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="../../public/img/icons/favicon.ico"/>
  <link rel="stylesheet" type="text/css" href="../../public/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../../public/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../../public/fonts/iconic/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="../../public/vendor/animate/animate.css">
  <link rel="stylesheet" type="text/css" href="../../public/vendor/css-hamburgers/hamburgers.min.css">
  <link rel="stylesheet" type="text/css" href="../../public/vendor/animsition/css/animsition.min.css">
  <link rel="stylesheet" type="text/css" href="../../public/vendor/select2/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../../public/vendor/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/util.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/main.css">
</head>
<body>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form method="POST" class="login100-form validate-form">
          <span class="login100-form-title p-b-26">
            Bem-vindo ao AdsControl
          </span>
          <span class="login100-form-title p-b-48">
            <i class="zmdi zmdi-font"></i>
          </span>

          <?php if ($erro): ?>
            <div class="text-center text-danger p-b-26" style="margin-top: -15px;">
              <?= htmlspecialchars($erro) ?>
            </div>
          <?php endif; ?>

          <div class="wrap-input100 validate-input" data-validate="Email válido é: a@b.c">
            <input class="input100" type="email" name="email" required>
            <span class="focus-input100" data-placeholder="Email"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Digite sua senha">
            <span class="btn-show-pass">
              <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" name="senha" required>
            <span class="focus-input100" data-placeholder="Senha"></span>
          </div>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn">
                Entrar
              </button>
            </div>
          </div>

          <div class="text-center p-t-115">
            <span class="txt1">Não tem uma conta?</span>
            <a class="txt2" href="register.php">Registrar</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="dropDownSelect1"></div>

  <script src="../../public/vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="../../public/vendor/animsition/js/animsition.min.js"></script>
  <script src="../../public/vendor/bootstrap/js/popper.js"></script>
  <script src="../../public/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="../../public/vendor/select2/select2.min.js"></script>
  <script src="../../public/vendor/daterangepicker/moment.min.js"></script>
  <script src="../../public/vendor/daterangepicker/daterangepicker.js"></script>
  <script src="../../public/vendor/countdowntime/countdowntime.js"></script>
  <script src="../../public/js/main.js"></script>

</body>
</html>
