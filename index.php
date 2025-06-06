<?php
include __DIR__ . '/service/announcement_service.php';
include __DIR__ . '/entity/announcement_entity.php';

$announcementService = new AnnouncementService();
$announcementsApproved = $announcementService->getApprovedAnnouncements();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Anúncios Aprovados - AdsControl</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f4f8ff] min-h-screen py-12 px-4 font-sans">

  <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow space-y-6">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold text-purple-700">🟣 Anúncios Aprovados</h1>
      <a href="app/auth/login.php"
        class="bg-purple-600 hover:bg-purple-800 text-white px-5 py-2 rounded-full shadow transition">
        Acessar App
      </a>
    </div>

    <form method="get" class="flex gap-4 items-center">
      <input type="text" id="searchInput" name="search"
        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
        placeholder="🔍 Procurar por título"
        class="px-4 py-2 rounded-full border border-gray-300 w-72 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-gray-700" />
      <select id="genderSelect" name="gender"
        class="px-4 py-2 rounded-full border border-gray-300 w-48 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-gray-700">
        <option value="">Selecionar gênero</option>
        <option value="M" <?= (isset($_GET['gender']) && $_GET['gender'] === 'masculino') ? 'selected' : '' ?>>
          Masculino</option>
        <option value="F" <?= (isset($_GET['gender']) && $_GET['gender'] === 'feminino') ? 'selected' : '' ?>>
          Feminino</option>
      </select>
      <button type="submit"
        class="bg-purple-600 hover:bg-purple-800 text-white px-5 py-2 rounded-full shadow transition">
        Filtrar
      </button>
    </form>

    <?php
    // Filter announcements by title and gender
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $gender = isset($_GET['gender']) ? trim($_GET['gender']) : '';

    if ($search !== '' || $gender !== '') {
      $announcementsApproved = array_filter($announcementsApproved, function ($data) use ($search, $gender) {
        $titleMatch = true;
        $genderMatch = true;

        if ($search !== '') {
          $titleMatch = stripos($data['title'], $search) !== false;
        }

        if ($gender !== '') {
          $genderValue = strtolower($data['target_gender']);
          $genderInput = strtolower($gender);
          if ($genderInput === 'm' || $genderInput === 'masculino') {
            $genderMatch = ($genderValue === 'm' || $genderValue === 'masculino');
          } elseif ($genderInput === 'f' || $genderInput === 'feminino') {
            $genderMatch = ($genderValue === 'f' || $genderValue === 'feminino');
          } else {
            $genderMatch = false;
          }
        }

        return $titleMatch && $genderMatch;
      });
    }
    ?>

    <div class="overflow-x-auto">
      <table class="min-w-full table-auto divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Imagem</th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Título</th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Ver</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          <?php foreach ($announcementsApproved as $data):
            $announcement = new Announcement();
            $announcement->fromArray($data);
            ?>
            <tr class="hover:bg-purple-50 transition">
              <td class="px-6 py-4">
                <img src="<?= htmlspecialchars($announcement->get_image_url()) ?>" alt="Imagem"
                  class="w-24 h-24 object-cover rounded-lg shadow">
              </td>
              <td class="px-6 py-4 font-medium text-gray-800">
                <?= htmlspecialchars($announcement->get_title()) ?>
              </td>
              <td class="px-6 py-4">
                <a href="app/announcement.php?id=<?= $announcement->get_id() ?>"
                  class="text-purple-600 hover:text-purple-800 font-semibold transition">
                  Ver Anúncio
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>
