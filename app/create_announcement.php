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

$announcementService = new AnnouncementService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $announcement = new Announcement();
  $announcement->fromArray($_POST);
  $announcement->set_user_id($_SESSION['user']->getId());
  $announcement->set_status("PENDENTE");
  $announcement->set_image_url("PATH");

  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/';

    $fileTmpPath = $_FILES['imagem']['tmp_name'];
    $fileName = uniqid('img_', true) . '_' . basename($_FILES['imagem']['name']);
    $destPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
      $announcement->set_image_url('uploads/' . $fileName);
    }
  }

  $announcementService->createAnnouncement($announcement);

  header("Location: user.php");
}

?>


<h1>Criar anuncio</h1>
<form method="POST" enctype="multipart/form-data">
  Titulo: <input type="text" name="title" required><br>
  Descricao: <input type="text" name="description" required><br>

  Gênero:
  <input type="radio" name="target_gender" value="M" required> Masculino
  <input type="radio" name="target_gender" value="F" required> Feminino
  <br>


  Faixa etária:
  <input type="radio" name="target_age" value="18-25" required> 18-25
  <input type="radio" name="target_age" value="26-35" required> 26-35
  <input type="radio" name="target_age" value="35+" required> 35+
  <br>
  Imagem: <input type="file" name="imagem" accept="image/*"><br>
  <button type="submit">Criar</button>
</form>