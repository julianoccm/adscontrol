
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

$announcementId = $_GET['id'] ?? null;
if (!$announcementId) {
  header("Location: user.php");
  exit;
}

$announcementService = new AnnouncementService();
$data = $announcementService->getAnnouncementById($announcementId);
if (!$data) {
  header("Location: user.php");
  exit;
}

$announcement = new Announcement();
$announcement->fromArray($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $announcementSave = new Announcement();
  $announcementSave->fromArray($_POST);
  $announcementSave->set_status("PENDENTE");
  $announcementSave->set_id($announcementId);

  $announcementService->updateAnnouncement($announcementSave);
  header("Location: user.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Anúncio - AdsControl</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../public/fonts/iconic/css/material-design-iconic-font.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f8ff] min-h-screen flex font-sans">

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

  <main class="flex-1 flex flex-col p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Editar um anúncio</h1>

    <form method="POST" class="bg-white rounded-xl shadow p-8 max-w-3xl w-full mx-auto space-y-6">
      <input type="hidden" name="target_gender" id="gender" value="<?= $announcement->get_target_gender() ?>">
      <input type="hidden" name="target_age" id="age" value="<?= $announcement->get_target_age() ?>">

      <h2 class="text-lg font-semibold text-gray-800">Dados do anúncio</h2>

      <div>
        <label class="text-sm font-semibold text-purple-700 block mb-1">Título do anúncio</label>
        <input type="text" name="title" value="<?= htmlspecialchars($announcement->get_title()) ?>" required
               class="w-full bg-gray-100 border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-400">
      </div>

      <div>
        <label class="text-sm font-semibold text-purple-700 block mb-1">Descrição do anúncio</label>
        <textarea name="description" rows="4" required
                  class="w-full bg-gray-100 border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-400"><?= htmlspecialchars($announcement->get_description()) ?></textarea>
      </div>

      <div>
        <h3 class="text-md font-semibold text-gray-800 mb-2">Alvo</h3>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
        <div class="flex gap-3 mb-4">
          <?php
            $genders = ['M' => 'Masculino', 'F' => 'Feminino'];
            foreach ($genders as $value => $label):
              $active = $announcement->get_target_gender() === $value;
          ?>
          <button type="button" data-role="selector" data-gender data-value="<?= $value ?>"
            class="selector px-4 py-2 rounded-full text-sm font-medium <?= $active ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-800' ?>">
            <?= $label ?>
          </button>
          <?php endforeach; ?>
        </div>

        <label class="block text-sm font-medium text-gray-700 mb-1">Faixa etária</label>
        <div class="flex gap-3 flex-wrap">
          <?php
            $ages = ['18-25', '26-35', '35+'];
            foreach ($ages as $age):
              $selected = $announcement->get_target_age() === $age;
          ?>
          <button type="button" data-role="selector" data-age data-value="<?= $age ?>"
            class="selector px-4 py-2 rounded-full text-sm font-medium <?= $selected ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-800' ?>">
            <?= $age ?>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div>
        <label class="text-sm font-semibold text-gray-700 block mb-2">Imagem do anúncio</label>
        <div class="border rounded overflow-hidden bg-[#f4f8ff] w-fit">
          <img src="../<?= $announcement->get_image_url() ?>" alt="Imagem do anúncio" class="w-48 h-48 object-cover">
        </div>
      </div>

      <button type="submit"
              class="w-full bg-purple-600 hover:bg-purple-800 text-white font-semibold py-3 rounded-full shadow text-center transition">
        Salvar alterações
      </button>
    </form>
  </main>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-role="selector"]').forEach(button => {
      button.addEventListener("click", () => {
        const value = button.dataset.value;

        if (button.dataset.gender !== undefined) {
          document.getElementById("gender").value = value;
          document.querySelectorAll('[data-gender]').forEach(b =>
            b.classList.remove("bg-purple-600", "text-white")
          );
          button.classList.add("bg-purple-600", "text-white");
        }

        if (button.dataset.age !== undefined) {
          document.getElementById("age").value = value;
          document.querySelectorAll('[data-age]').forEach(b =>
            b.classList.remove("bg-purple-600", "text-white")
          );
          button.classList.add("bg-purple-600", "text-white");
        }
      });
    });
  });
</script>

</body>
</html>
