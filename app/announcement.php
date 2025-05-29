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

  <div class="bg-white p-8 rounded shadow-md w-full max-w-xl">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Detalhes do Anúncio</h1>

    <div class="space-y-4">
      <h2 class="text-xl font-semibold text-gray-800">Título: <?= htmlspecialchars($announcement->get_title()) ?></h2>
      <p class="text-gray-700"><strong>Descrição:</strong> <?= htmlspecialchars($announcement->get_description()) ?></p>
      <p class="text-gray-700"><strong>Data de criação:</strong> <?= htmlspecialchars($announcement->get_created_at()) ?></p>
      <p class="text-gray-700">
        <strong>Status:</strong>
        <span class="px-2 py-1 rounded-full text-sm 
          <?= $announcement->get_status() === 'PENDENTE' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' ?>">
          <?= htmlspecialchars($announcement->get_status()) ?>
        </span>
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
