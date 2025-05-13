<?php
session_start();
session_unset();
session_destroy();

showSweetAlert("Kamu Berhasil Keluar!", "success", "../auth/login.php");

function showSweetAlert($message, $type, $redirect)
{
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Logout</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <script>
            Swal.fire({
                icon: '<?= $type ?>',
                title: '<?= $message ?>',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didClose: () => {
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
