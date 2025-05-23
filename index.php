<?php
include __DIR__ . '/service/announcement_service.php';
include __DIR__ . '/entity/announcement_entity.php';

$announcementService = new AnnouncementService();
$announcementsApproved = $announcementService->getApprovedAnnouncements();
?>

<a href="app/auth/login.php">Acessar App</a>

<h1>Anuncios</h1>

<div>
  <?php
  for ($i = 0; $i < count($announcementsApproved); $i++) {
    $announcement = new Announcement();
    $announcement->fromArray($announcementsApproved[$i]);




    if ($i === 0) {
      echo "<table border='1' cellpadding='5' cellspacing='0'>";
      echo "<tr>";
      echo "<th>Imagem</th>";
      echo "<th>Título</th>";
      echo "<th>Ver anuncio</th>";
      echo "</tr>";
    }

    echo "<tr>";
    echo "<td><img src='" . htmlspecialchars($announcement->get_image_url()) . "' alt='Imagem' style='max-width:100px;max-height:100px;'></td>";
    echo "<td>" . htmlspecialchars($announcement->get_title()) . "</td>";
    echo "<td><a href='app/announcement.php?id=" . $announcement->get_id() . "'>Ver</a></td>";
    echo "</tr>";

    if ($i === end($announcementsApproved)) {
      echo "</table>";
    }
  }
  ?>
</div>