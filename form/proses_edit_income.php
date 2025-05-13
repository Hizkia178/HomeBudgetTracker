<?php
session_start();
require_once '../databases/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $income_id = $_POST['income_id'];
    $income_date = $_POST['income_date'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];

    if (empty($income_date) || empty($description) || empty($category) || empty($amount)) {
        showToast("Semua field harus diisi!", "danger", "../form/income_index.php", "times-circle");
        exit();
    }

    if ($income_id) {
        $stmt = $conn->prepare("UPDATE income SET income_date = ?, description = ?, category = ?, amount = ? WHERE id = ?");
        $stmt->bind_param("sssdi", $income_date, $description, $category, $amount, $income_id);
        $stmt->execute();
        $stmt->close();

        showToast("Income berhasil diperbarui.", "success", "../form/income_index.php", "check-circle");
    } else {
        $stmt = $conn->prepare("INSERT INTO income (user_id, income_date, description, category, amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $_SESSION['user_id'], $income_date, $description, $category, $amount);
        $stmt->execute();
        $stmt->close();

        showToast("Income baru berhasil ditambahkan.", "success", "../form/income_index.php", "check-circle");
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
