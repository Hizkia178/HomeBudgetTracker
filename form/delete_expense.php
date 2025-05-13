<?php
session_start();
require_once '../databases/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        showToast("Pengeluaran berhasil dihapus.", "success", "../form/index.php");
    } else {
        showToast("Gagal menghapus pengeluaran.", "danger", "../form/index.php");
    }

    $stmt->close();
}

// Fungsi toast konsisten
function showToast($message, $type, $redirect)
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
                title: "<?= $type === 'success' ? 'Berhasil!' : 'Gagal!' ?>",
                text: "<?= htmlspecialchars($message) ?>",
                icon: "<?= $type === 'danger' ? 'error' : $type ?>",
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
