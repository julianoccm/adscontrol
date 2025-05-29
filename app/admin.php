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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Admin - AdsControl</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="../public/fonts/iconic/css/material-design-iconic-font.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .fade-in {
      animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="bg-[#f4f8ff] min-h-screen flex font-sans">

  <!-- Sidebar -->
  <aside class="w-16 bg-[#1e1f3d] flex flex-col justify-between items-center py-6">
    <i class="zmdi zmdi-font zmdi-hc-2x text-white text-2xl"></i>
    <a href="auth/logout.php" class="text-gray-300 hover:text-white text-2xl text-xl">
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
        <h1 class="text-2xl font-semibold text-gray-800">Controle de anúncios</h1>
        <input type="text" id="searchInput" placeholder="🔍 Procurar por título"
               class="px-4 py-2 rounded-full border border-gray-300 w-72 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-gray-700" />
      </div>

      <div class="bg-white rounded-xl shadow overflow-hidden fade-in">
        <table class="w-full text-left text-sm text-gray-700">
          <thead class="bg-[#e3e6f0] text-gray-700 font-medium">
            <tr>
              <th class="px-6 py-3">Título</th>
              <th class="px-6 py-3">Foto</th>
              <th class="px-6 py-3">Ação</th>
            </tr>
          </thead>
          <tbody id="announcementTable" class="divide-y divide-gray-200">
            <?php foreach ($announcementsPending as $data):
              $announcement = new Announcement();
              $announcement->fromArray($data);
            ?>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-6 py-4"><?= htmlspecialchars($announcement->get_title()) ?></td>
              <td class="px-6 py-4">
                <a href="announcement.php?id=<?= $announcement->get_id() ?>"
                   class="px-4 py-1 text-white text-2xl rounded-full bg-gradient-to-r from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-700 transition shadow text-sm">
                  Visualizar
                </a>
              </td>
              <td class="px-6 py-4 space-x-2">
                <a href="delete_announcement_hander.php?id=<?= $announcement->get_id() ?>"
                   class="px-4 py-1 text-white text-2xl rounded-full bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 transition shadow text-sm">
                  Excluir
                </a>
                <a href="approve_announcement_hander.php?id=<?= $announcement->get_id() ?>"
                   class="px-4 py-1 text-white text-2xl rounded-full bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 transition shadow text-sm">
                  Aprovar
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("#announcementTable tr");

    searchInput.addEventListener("input", function() {
      const value = this.value.toLowerCase();
      rows.forEach(row => {
        const title = row.querySelector("td")?.innerText.toLowerCase() || "";
        row.style.display = title.includes(value) ? "" : "none";
      });
    });
  </script>

</body>
</html>
