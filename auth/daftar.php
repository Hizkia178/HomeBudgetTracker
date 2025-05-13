<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s, box-shadow 0.3s;
            max-width: 450px; 
            width: 100%;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .btn-primary i {
            margin-right: 8px;
        }
        .input-group-text {
            background-color: #f1f3f5;
            border-radius: 8px 0 0 8px;
        }
        .input-group-text-eye {
            background-color: #f1f3f5;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
        }
        .form-label {
            font-weight: 500;
            color: #343a40;
        }
        .form-control {
            border-radius: 0;
            box-shadow: none;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .card-title {
            font-weight: 600;
            color: #343a40;
        }
        .text-primary {
            transition: color 0.3s;
        }
        .text-primary:hover {
            color: #0056b3 !important;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Sign Up Form -->
            <div class="card dashboard-card mx-auto" data-aos="fade-up" data-aos-duration="1000">
                <div class="card-body">
                    <h5 class="card-title text-center">Formulir Pendaftaran</h5>
                    <form id="signupForm" action="../auth/proses_daftar.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-user'></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="e.g., john_doe" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="e.g., john@example.com" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                <span class="input-group-text input-group-text-eye" onclick="togglePassword('password', this)">
                                    <i class='bx bx-show'></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                                <span class="input-group-text input-group-text-eye" onclick="togglePassword('confirmPassword', this)">
                                    <i class='bx bx-show'></i>
                                </span>
                            </div>
                        </div>
                        <button type="submit" data-bs-toggle="tooltip" title="Click to create your account" class="btn btn-primary shadow">
                            <i class='bx bx-user-plus'></i> Sign Up
                        </button>
                    </form>
                    <div class="mt-3 text-center">
                        <p class="mb-0">Already have an account? 
                            <a href="../auth/login.php" class="text-primary" style="text-decoration: none;" data-bs-toggle="tooltip" title="Go to login page">Login Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
        // Toggle password visibility
        function togglePassword(inputId, eyeIcon) {
            const input = document.getElementById(inputId);
            const icon = eyeIcon.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            } else {
                input.type = 'password';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            }
        }
    </script>
    <script src="../script/tooltip.js"></script>
</body>
</html>