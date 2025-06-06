<?php
include __DIR__ . '/../persistence/database.php';
include __DIR__ . '/../service/announcement_service.php';
include __DIR__ . '/../entity/announcement_entity.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "Anúncio não encontrado.";
  return;
}

$announcementService = new AnnouncementService();
$data = $announcementService->getAnnouncementById($id);

if (!$data) {
  echo "Anúncio não encontrado.";
  return;
}

$announcement = new Announcement();
$announcement->fromArray($data);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Detalhes do Anúncio - AdsControl</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <a href="javascript:history.back()" class="absolute top-8 left-8 flex items-center text-blue-600 hover:text-blue-800">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left mr-2" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    Voltar
  </a>

  <div class="bg-white p-8 rounded shadow-md w-full max-w-xl">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Detalhes do Anúncio</h1>

    <div class="space-y-4">
      <h2 class="text-xl font-semibold text-gray-800">Título: <?= htmlspecialchars($announcement->get_title()) ?></h2>
      <p class="text-gray-700"><strong>Descrição:</strong> <?= htmlspecialchars($announcement->get_description()) ?></p>
      <p class="text-gray-700"><strong>Data de criação:</strong>
        <?php
          $createdAt = $announcement->get_created_at();
          $date = DateTime::createFromFormat('Y-m-d H:i:s', $createdAt);
          echo $date ? $date->format('d/m/Y') : htmlspecialchars($createdAt);
        ?>
      </p>

      <?php if ($announcement->get_image_url()): ?>
        <div>
          <p class="text-gray-700 mb-1"><strong>Imagem:</strong></p>
          <img src="../<?= htmlspecialchars($announcement->get_image_url()) ?>"
               alt="Imagem do anúncio"
               class="w-full max-h-96 object-cover rounded shadow">
        </div>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
