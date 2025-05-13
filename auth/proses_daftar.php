<?php
session_start();
include '../databases/db.php';

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password !== $confirmPassword) {
    showSweetAlert("Password dan konfirmasi password tidak sama!", "error", "../auth/daftar.php");
    exit();
}

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    showSweetAlert("Username atau Email sudah terdaftar!", "warning", "../auth/daftar.php");
    exit();
}
$stmt->close();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    showSweetAlert("Pendaftaran berhasil! Silakan login.", "success", "../auth/login.php");
} else {
    showSweetAlert("Pendaftaran gagal: " . $stmt->error, "error", "../auth/daftar.php");
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
