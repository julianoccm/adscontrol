<?php

include __DIR__ . '/../persistence/database.php';
include __DIR__ . '/../service/announcement_service.php';
include __DIR__ . '/../entity/announcement_entity.php';


$id = isset($_GET['id']) ? $_GET['id'] : null;

if (empty($id)) {
  echo "Anuncio não encontrado.";
  return;
}

$announcementService = new AnnouncementService();
$entityDb = $announcementService->getAnnouncementById($id);
$announcement = new Announcement();
$announcement->fromArray($entityDb);

echo "<h1>Detalhes do anúncio</h1>";
echo "<h2>Título: " . $announcement->get_title() . "</h2>";
echo "<p>Descrição: " . $announcement->get_description() . "</p>";
echo "<p>Data de criação: " . $announcement->get_created_at() . "</p>";
echo "<p>Status: " . $announcement->get_status() . "</p>";
echo "<p>Foto: <img src='../" . $announcement->get_image_url() . "' alt='Foto do anúncio' /></p>";