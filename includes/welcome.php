<link rel="stylesheet" href="../assets/body.css">
<!-- Welcome Section -->
<div class="welcome-section" data-aos="fade-up" data-aos-duration="1000">
    <?php
    include '../databases/db.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];


    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();


    $totalIncome = 0;
    $stmtIncome = $conn->prepare("SELECT SUM(amount) AS total FROM income WHERE user_id = ? AND MONTH(income_date) = MONTH(CURDATE()) AND YEAR(income_date) = YEAR(CURDATE())");
    $stmtIncome->bind_param("i", $user_id);
    $stmtIncome->execute();
    $resultIncome = $stmtIncome->get_result();
    if ($row = $resultIncome->fetch_assoc()) {
        $totalIncome = $row['total'] ?? 0;
    }
    $stmtIncome->close();

    $totalExpense = 0;
    $stmtExpense = $conn->prepare("SELECT SUM(amount) AS total FROM expenses WHERE user_id = ? AND MONTH(expense_date) = MONTH(CURDATE()) AND YEAR(expense_date) = YEAR(CURDATE())");
    $stmtExpense->bind_param("i", $user_id);
    $stmtExpense->execute();
    $resultExpense = $stmtExpense->get_result();
    if ($row = $resultExpense->fetch_assoc()) {
        $totalExpense = $row['total'] ?? 0;
    }
    $stmtExpense->close();

    $monthlyBudget = 5000;
    $budgetPercent = $monthlyBudget > 0 ? ($totalExpense / $monthlyBudget) * 100 : 0;
    $currentBalance = $totalIncome - $totalExpense;

    ?>

   <div class="row align-items-center">
        <div class="col-md-7">
            <h2 class="mb-2">Welcome back, <?= htmlspecialchars($username) ?>!</h2>
            <p class="mb-0">
                Your financial overview is looking good. You've spent <?= number_format($budgetPercent, 1) ?>% of your monthly budget.
            </p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <h4 class="mb-1">Current Balance</h4>
            <h2 class="mb-0">$<?= number_format($currentBalance, 2) ?></h2>
        </div>
    </div>
</div>

