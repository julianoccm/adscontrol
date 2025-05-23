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

$announcementId = isset($_GET['id']) ? $_GET['id'] : null;

if ($announcementId === null) {
  header('Location: user.php');
  exit;
}

$announcementService = new AnnouncementService();
$announcementEntity = $announcementService->getAnnouncementById($announcementId);

if ($announcementEntity === false) {
  header("Location: user.php");
  exit;
}

$announcement = new Announcement();
$announcement->fromArray($announcementEntity);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $announcementSave = new Announcement();
  $announcementSave->fromArray($_POST);
  $announcementSave->set_status("PENDENTE");
  $announcementSave->set_id($announcementId);

  $announcementService->updateAnnouncement($announcementSave);

  header("Location: user.php");
}

?>


<h1>Editar anuncio</h1>
<form method="POST" enctype="multipart/form-data">
  Titulo: <input type="text" name="title" required value="<?php echo $announcement->get_title() ?>"><br>
  Descricao: <input type="text" name="description" required value="<?php echo $announcement->get_description() ?>"><br>

  Gênero:
  <input type="radio" name="target_gender" value="M" required <?php if ($announcement->get_target_gender() === 'M')
    echo 'checked'; ?>> Masculino
  <input type="radio" name="target_gender" value="F" required <?php if ($announcement->get_target_gender() === 'F')
    echo 'checked'; ?>> Feminino
  <br>


  Faixa etária:
  <input type="radio" name="target_age" value="18-25" required <?php if ($announcement->get_target_age() === '18-25')
    echo 'checked'; ?>> 18-25
  <input type="radio" name="target_age" value="26-35" required <?php if ($announcement->get_target_age() === '26-35')
    echo 'checked'; ?>> 26-35
  <input type="radio" name="target_age" value="35+" required <?php if ($announcement->get_target_age() === '35+')
    echo 'checked'; ?>> 35+
  <br>

  <button type="submit">Editar</button>
</form