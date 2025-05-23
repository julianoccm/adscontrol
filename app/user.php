<?php
include __DIR__ . '/../entity/user_entity.php';
include __DIR__ . '/../entity/announcement_entity.php';
include __DIR__ . '/../service/announcement_service.php';

session_start();

if (!isset($_SESSION['user'])) {
  header("Location: auth/login.php");
  exit;
}

if ($_SESSION['user']->getRole() !== 'USER') {
  header("Location: admin.php");
  exit;
}

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

echo "<h1>Home de usuario normal</h1>";

$announcementService = new AnnouncementService();
$userId = $_SESSION['user']->getId();
$announcements = $announcementService->getAnnouncementsByUserId($userId);

echo "<a href='create_announcement.php'>Criar anuncio</a><br>";
echo "<a href='auth/logout.php'>Logout</a>";

if (empty($announcements)) {
  echo "<p>Sem anuncios publicados.</p>";
} else {
  echo "<h2>Seus anuncios:</h2>";
  foreach ($announcements as $ads) {
    $announcement = new Announcement();
    $announcement->fromArray($ads);

    if ($ads === reset($announcements)) {
      echo "<table border='1' cellpadding='5' cellspacing='0'>";
      echo "<tr>";
      echo "<th>Id</th>";
      echo "<th>Título</th>";
      echo "<th>Status</th>";
      echo "<th>Criado em</th>";
      echo "<th>Ver anuncio</th>";
      echo "<th>Ação</th>";
      echo "</tr>";
    }

    echo "<tr>";
    echo "<td>" . htmlspecialchars($announcement->get_id()) . "</td>";
    echo "<td>" . htmlspecialchars($announcement->get_title()) . "</td>";
    echo "<td>" . htmlspecialchars($announcement->get_status()) . "</td>";
    echo "<td>" . htmlspecialchars($announcement->get_created_at()) . "</td>";
    echo "<td><a href='announcement.php?id=" . $announcement->get_id() . "'>Ver</a></td>";
    echo "<td>
      <a href='edit_announcement.php?id=" . $announcement->get_id() . "'>Editar</a>
      <a href='delete_announcement_hander.php?id=" . $announcement->get_id() . "'>Excluir</a>
    </td>";
    echo "</tr>";

    if ($ads === end($announcements)) {
      echo "</table>";
    }
  }
}
?>