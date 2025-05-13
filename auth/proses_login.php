<?php
session_start();
include '../databases/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        showSweetAlert("Email atau password tidak boleh kosong!", "error", "../auth/login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $dbEmail, $dbPassword);
        $stmt->fetch();

        if (password_verify($password, $dbPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $dbEmail;

            showSweetAlert("Login berhasil, selamat datang!", "success", "../main/index.php");
        } else {
            showSweetAlert("Password salah, coba lagi.", "error", "../auth/login.php");
        }
    } else {
        showSweetAlert("Email tidak ditemukan, coba daftar.", "warning", "../auth/daftar.php");
    }
}

function showSweetAlert($message, $type, $redirect)
{
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Login</title>
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
