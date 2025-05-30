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
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Criar Anúncio - AdsControl</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f8ff] min-h-screen flex items-center justify-center font-sans">

  <form method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-8 max-w-3xl w-full mx-auto space-y-6">
    <input type="hidden" name="target_gender" id="gender">
    <input type="hidden" name="target_age" id="age">

    <h2 class="text-lg font-semibold text-gray-800">Novo Anúncio</h2>

    <div>
      <label class="text-sm font-semibold text-purple-700 block mb-1">Título do anúncio</label>
      <input type="text" name="title" required
             class="w-full bg-gray-100 border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-400">
    </div>

    <div>
      <label class="text-sm font-semibold text-purple-700 block mb-1">Descrição do anúncio</label>
      <textarea name="description" rows="4" required
                class="w-full bg-gray-100 border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-400"></textarea>
    </div>

    <div>
      <h3 class="text-md font-semibold text-gray-800 mb-2">Alvo</h3>
      <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
      <div class="flex gap-3 mb-4">
        <button type="button" data-role="selector" data-gender data-value="M"
          class="selector px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
          Masculino
        </button>
        <button type="button" data-role="selector" data-gender data-value="F"
          class="selector px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
          Feminino
        </button>
      </div>

      <label class="block text-sm font-medium text-gray-700 mb-1">Faixa etária</label>
      <div class="flex gap-3 flex-wrap">
        <button type="button" data-role="selector" data-age data-value="18-25"
          class="selector px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
          18-25
        </button>
        <button type="button" data-role="selector" data-age data-value="26-35"
          class="selector px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
          26-35
        </button>
        <button type="button" data-role="selector" data-age data-value="35+"
          class="selector px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
          35+
        </button>
      </div>
    </div>

    <div>
      <label class="text-sm font-semibold text-gray-700 block mb-2">Imagem do anúncio</label>
      <input type="file" name="imagem" accept="image/*"
             class="block w-full text-sm text-gray-700 border border-gray-300 rounded cursor-pointer
                    file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold
                    file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
    </div>

    <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-800 text-white font-semibold py-3 rounded-full shadow text-center transition">
      Publicar Anúncio
    </button>
  </form>

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
