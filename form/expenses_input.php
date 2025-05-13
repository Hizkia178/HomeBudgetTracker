<?php
session_start();
require_once '../databases/db.php';

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    showSweetAlert("Anda harus login dulu!", "error", "../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data dari form
$expenseDate = $_POST['expenseDate'] ?? '';
$expenseDescription = $_POST['expenseDescription'] ?? '';
$expenseCategory = $_POST['expenseCategory'] ?? '';
$expenseAmount = $_POST['expenseAmount'] ?? 0;

// Cek koneksi dulu
if (!$conn) {
    showSweetAlert("Koneksi database gagal.", "error", "../form/index.php");
    exit();
}

// Siapkan query
$query = "INSERT INTO expenses (user_id, expense_date, description, category, amount) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);

if (!$stmt) {
    showSweetAlert("Query gagal disiapkan: " . $conn->error, "error", "../form/index.php");
    exit();
}

$stmt->bind_param("isssd", $user_id, $expenseDate, $expenseDescription, $expenseCategory, $expenseAmount);

if ($stmt->execute()) {
    showSweetAlert("Pengeluaran berhasil ditambahkan!", "success", "../form/index.php");
} else {
    showSweetAlert("Gagal menambahkan pengeluaran: " . $stmt->error, "error", "../form/index.php");
}

$stmt->close();
$conn->close();

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
        title: '<?= $message ?>',
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
