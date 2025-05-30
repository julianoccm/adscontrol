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
$userId = $_SESSION['user']->getId();
$announcements = $announcementService->getAnnouncementsByUserId($userId);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Meus Anúncios - AdsControl</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../public/fonts/iconic/css/material-design-iconic-font.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f8ff] min-h-screen flex font-sans">

  <!-- Sidebar -->
  <aside class="w-16 bg-[#1e1f3d] flex flex-col justify-between items-center py-6">
    <i class="zmdi zmdi-font zmdi-hc-2x text-white"></i>
    <a href="auth/logout.php" class="text-gray-300 hover:text-white text-xl">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
           viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5"/>
      </svg>
    </a>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8">
    <div class="max-w-6xl mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Anúncios</h1>
        <div class="flex gap-4 items-center">
          <input type="text" id="searchInput" placeholder="🔍 Procurar por título"
                 class="px-4 py-2 rounded-full border border-gray-300 w-72 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-gray-700" />
          <a href="create_announcement.php"
             class="bg-purple-600 hover:bg-purple-800 text-white px-4 py-2 rounded-full font-semibold transition">
            + Criar um anúncio
          </a>
        </div>
      </div>

      <?php if (empty($announcements)): ?>
        <p class="text-gray-500">Você ainda não publicou nenhum anúncio.</p>
      <?php else: ?>
        <div class="bg-white rounded-xl shadow overflow-hidden">
          <table class="w-full text-left text-sm text-gray-700">
            <thead class="bg-[#e3e6f0] text-gray-700 font-medium">
              <tr>
                <th class="px-6 py-3">Título</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Data de Criação</th>
                <th class="px-6 py-3">Foto</th>
                <th class="px-6 py-3">Ação</th>
              </tr>
            </thead>
            <tbody id="userAnnouncementTable" class="divide-y divide-gray-200">
              <?php foreach ($announcements as $ads):
                $announcement = new Announcement();
                $announcement->fromArray($ads);
              ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4"><?= htmlspecialchars($announcement->get_title()) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($announcement->get_status()) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($announcement->get_created_at()) ?></td>
                <td class="px-6 py-4">
                  <a href="announcement.php?id=<?= $announcement->get_id() ?>"
                     class="px-4 py-1 text-white rounded-full bg-blue-500 hover:bg-blue-600 transition shadow text-sm">
                    Visualizar
                  </a>
                </td>
                <td class="px-6 py-4 space-x-2">
                  <a href="edit_announcement.php?id=<?= $announcement->get_id() ?>"
                     class="px-4 py-1 text-white rounded-full bg-yellow-500 hover:bg-yellow-600 transition shadow text-sm">
                    Editar
                  </a>
                  <a href="delete_announcement_hander.php?id=<?= $announcement->get_id() ?>"
                     class="px-4 py-1 text-white rounded-full bg-red-500 hover:bg-red-600 transition shadow text-sm">
                    Excluir
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script>
    const input = document.getElementById("searchInput");
    const rows = document.querySelectorAll("#userAnnouncementTable tr");

    input.addEventListener("input", function () {
      const value = this.value.toLowerCase();
      rows.forEach(row => {
        const title = row.querySelector("td")?.innerText.toLowerCase() || "";
        row.style.display = title.includes(value) ? "" : "none";
      });
    });
  </script>

</body>
</html>
