<?php

include __DIR__ . '/../persistence/database.php';
include __DIR__ . '/../service/announcement_service.php';
include __DIR__ . '/../entity/announcement_entity.php';
include __DIR__ . '/../entity/user_entity.php';


session_start();

if (!isset($_SESSION['user'])) {
  header("Location: auth/login.php");
  exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (empty($id)) {
  header("Location: user.php");
  exit;
}

$announcementService = new AnnouncementService();
$announcementService->deleteAnnouncement($id);

if ($_SESSION['user']->getRole() !== 'USER') {
  header("Location: admin.php");
  exit;
}

header("Location: user.php");