<?php
session_start(); 

require_once '../databases/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Cek apakah user login
    if (!isset($_SESSION['user_id'])) {
        showSweetAlert("Anda harus login terlebih dahulu!", "error", "../auth/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Ambil data dari form
    $incomeDate = $_POST['incomeDate'];
    $incomeDescription = $_POST['incomeDescription'];
    $incomeCategory = $_POST['incomeCategory'];
    $incomeAmount = $_POST['incomeAmount'];

    // Validasi input
    if (empty($incomeDate) || empty($incomeDescription) || empty($incomeCategory) || empty($incomeAmount)) {
        showSweetAlert("Semua field harus diisi!", "warning", "../form/income_index.php");
        exit();
    }

    // Simpan data ke database
    $stmt = $conn->prepare("INSERT INTO income (user_id, income_date, description, category, amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $user_id, $incomeDate, $incomeDescription, $incomeCategory, $incomeAmount);

    if ($stmt->execute()) {
        showSweetAlert("Pemasukan berhasil ditambahkan!", "success", "../form/income_index.php");
    } else {
        showSweetAlert("Gagal menambahkan pemasukan: " . $stmt->error, "error", "../form/income_index.php");
    }

    $stmt->close();
    $conn->close();
}

// Fungsi notifikasi SweetAlert2
function showSweetAlert($message, $type, $redirect)
{
?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Notifikasi</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '<?= $type ?>',
                title: '<?= addslashes($message) ?>',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                willClose: () => {
                    window.location.href = "<?= $redirect ?>";
                }
            });
        </script>
    </body>
    </html>
<?php
    exit();
}
?>
