<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pustaka Hub</title>

  <!-- Google Fonts & Bootstrap -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Custom CSS (Panggil dari style.css atau taruh kode CSS di atas ke sini) -->
  <?= $this->include('components/style') ?>
  </head>

<body>
  <div class="app-container">
    
    <!-- Memanggil Sidebar (Tetap) -->
    <?= $this->include('components/sidebar') ?>

    <div class="main-area">
      <!-- Memanggil Header (Tetap di atas) -->
      <?= $this->include('components/header') ?>

      <!-- Area Scrollable -->
      <div class="content-scrollable">
        <!-- Render Konten Utama (Bisa Dashboard, Buku, dll) -->
        <?= $this->renderSection('content') ?>
      </div>
      
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 