<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Home Budget Tracker</title>

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

  <!-- Boxicons CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">

  <!-- AOS CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
</head>

<body>
  <?php include '../includes/navbar.php'; ?>

  <div class="container mt-4">
    <?php include '../includes/welcome.php'; ?>
    <?php include '../form/income.php'; ?>
  </div>
  <!-- Bootstrap Bundle JS (with Popper) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <?php include '../includes/footer.php'; ?>
  <!-- AOS JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="../script/tooltip.js"></script>
  <script src="../script/modal_income.js"></script>
  <script src="../notes/delete_income.js"></script>
  <script>
    AOS.init(); // Inisialisasi AOS
  </script>
</body>

</html>