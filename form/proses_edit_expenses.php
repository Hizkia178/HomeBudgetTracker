<?php
session_start();
require_once '../databases/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_id = $_POST['expense_id'];
    $expense_date = $_POST['expense_date'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    if (empty($expense_date) || empty($description) || empty($category) || empty($amount)) {
        showToast("Semua field harus diisi!", "danger", "../form/index.php", "times-circle");
        exit();
    }

    if ($expense_id) {
        $stmt = $conn->prepare("UPDATE expenses SET expense_date = ?, description = ?, category = ?, amount = ? WHERE id = ?");
        $stmt->bind_param("sssdi", $expense_date, $description, $category, $amount, $expense_id);
        $stmt->execute();
        $stmt->close();

        showToast("Pengeluaran berhasil diperbarui.", "success", "../form/index.php", "check-circle");
    } else {

        $stmt = $conn->prepare("INSERT INTO expenses (user_id, expense_date, description, category, amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $_SESSION['user_id'], $expense_date, $description, $category, $amount);
        $stmt->execute();
        $stmt->close();

        showToast("Pengeluaran baru berhasil ditambahkan.", "success", "../form/index.php", "check-circle");
    }
}

// Fungsi untuk menampilkan toast Bootstrap dengan header dan ikon
function showToast($message, $type, $redirect, $icon)
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
                title: "<?= $type == 'success' ? 'Berhasil!' : 'Gagal!' ?>",
                text: "<?= htmlspecialchars($message) ?>",
                icon: "<?= $type ?>",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "<?= $redirect ?>";
            });
        </script>
    </body>
    </html>
<?php
    exit();
}

?>
