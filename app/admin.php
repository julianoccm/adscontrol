<?php
include __DIR__ . '/../entity/user_entity.php';
include __DIR__ . '/../entity/announcement_entity.php';
include __DIR__ . '/../service/announcement_service.php';

session_start();

if (!isset($_SESSION['user'])) {
  header("Location: auth/login.php");
  exit;
}

if ($_SESSION['user']->getRole() !== 'ADMIN') {
  header("Location: user.php");
  exit;
}

$announcementService = new AnnouncementService();
$announcementsPending = $announcementService->getPendingAnnouncements();
$announcementsApproved = $announcementService->getApprovedAnnouncements();

echo "<a href='auth/logout.php'>Logout</a>";

echo "<h1>Home de usuario admin</h1>";
echo "<h1>Anuncios pendente aprovacao</h1>";
if (empty($announcementsPending)) {
  echo "<p>Sem anuncios pendente aprovacao.</p>";
} else {
  for ($i = 0; $i < count($announcementsPending); $i++) {
    $announcement = new Announcement();
    $announcement->fromArray($announcementsPending[$i]);

    if ($i === 0) {
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
      <a href='approve_announcement_hander.php?id=" . $announcement->get_id() . "'>Aprovar</a>
      <a href='delete_announcement_hander.php?id=" . $announcement->get_id() . "'>Excluir</a>
    </td>";
    echo "</tr>";

    if ($i === count($announcementsPending) - 1) {
      echo "</table>";
    }
  }
}

echo "<h1>Anuncios aprovados</h1>";

if (empty($announcementsApproved)) {
  echo "<p>Sem anuncios aprovados.</p>";
} else {
  for ($i = 0; $i < count($announcementsApproved); $i++) {
    $announcement = new Announcement();
    $announcement->fromArray($announcementsApproved[$i]);

    if ($i === 0) {
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
      <a href='unapprove_announcement_hander.php?id=" . $announcement->get_id() . "'>Pendenciar</a>
      <a href='delete_announcement_hander.php?id=" . $announcement->get_id() . "'>Excluir</a>
    </td>";
    echo "</tr>";

    if ($i === end($announcementsApproved)) {
      echo "</table>";
    }
  }
}

?>