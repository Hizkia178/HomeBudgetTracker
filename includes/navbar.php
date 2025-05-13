<link rel="stylesheet" href="../assets/body.css">
<?php
require_once '../databases/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top" data-aos="fade-down" data-aos-duration="800">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class='bx bx-wallet me-2' style="font-size: 1.5rem; color: var(--primary-color);"></i>
            <span>HomeBudgetTracker</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class='bx bx-menu' style="font-size: 1.8rem;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../main/index.php">
                        <i class='bx bxs-home me-1'></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../form/index.php">
                        <i class='bx bx-stats me-1'></i> Expenses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../form/income_index.php">
                        <i class='bx bx-dollar me-1'></i> Income
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-user-circle me-1'></i> Profile
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="profile-card">
                                    <i class="bx bx-user-circle profile-icon"></i>
                                    <div class="profile-details">
                                        <h6><?= htmlspecialchars($user['username']) ?></h6>
                                        <small><?= htmlspecialchars($user['email']) ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item logout" href="#">
                                <i class='bx bx-log-out me-1'></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <div class="ms-lg-3 mt-3 mt-lg-0">
                <a href="#" class="btn btn-primary shadow" data-bs-toggle="tooltip" title="Click to add a new expense">
                    <i class='bx bx-plus me-1'></i> Add Expense
                </a>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelector('.btn.btn-primary').addEventListener('click', function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah kamu serius?',
            text: 'Kamu akan menambah data keuangan baru. Pastikan datanya sudah benar!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, tambah data!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../form/index.php';
            }
        });
    });
    document.querySelector('.logout').addEventListener('click', function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: 'Kamu akan keluar dari aplikasi. Pastikan sudah menyimpan semua data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../auth/logout.php';
            }
        });
    });
</script>
<style>
    .profile-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 0.5rem;
        background: rgba(248, 249, 250, 0.95);
        backdrop-filter: blur(5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        z-index: 2;
        gap: 1rem;
    }

    .profile-card:hover {
        transform: translateY(-3px);
    }

    .profile-card .profile-icon {
        font-size: 2.5rem;
        color: #5B72F2;
        background: #fff;
        padding: 8px;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-card .profile-details h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
        color: #1a1a1a;
    }

    .profile-card .profile-details small {
        font-size: 0.85rem;
        color: #6c757d;
    }
</style>