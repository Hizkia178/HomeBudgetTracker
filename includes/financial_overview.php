<?php
include '../databases/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


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


$savings = $totalIncome - $totalExpense;

$savingsPercentage = $totalIncome > 0 ? ($savings / $totalIncome) * 100 : 0;

$stmtSavings = $conn->prepare("INSERT INTO savings (user_id, amount, savings_date) VALUES (?, ?, CURDATE())");
$stmtSavings->bind_param("id", $user_id, $savings);
$stmtSavings->execute();
$stmtSavings->close();

$monthlyBudget = 10000;
$budgetSpent = $totalExpense;
$budgetPercent = ($budgetSpent / $monthlyBudget) * 100;


$totalExpenseLastMonth = 0;
$stmtExpenseLastMonth = $conn->prepare("SELECT SUM(amount) AS total FROM expenses WHERE user_id = ? AND MONTH(expense_date) = MONTH(CURDATE()) - 1 AND YEAR(expense_date) = YEAR(CURDATE())");
$stmtExpenseLastMonth->bind_param("i", $user_id);
$stmtExpenseLastMonth->execute();
$resultExpenseLastMonth = $stmtExpenseLastMonth->get_result();
if ($row = $resultExpenseLastMonth->fetch_assoc()) {
    $totalExpenseLastMonth = $row['total'] ?? 0;
}
$stmtExpenseLastMonth->close();


if ($totalExpenseLastMonth > 0) {
    $expensePercentageChange = (($totalExpense - $totalExpenseLastMonth) / $totalExpenseLastMonth) * 100;
} elseif ($totalExpense > 0) {
    $expensePercentageChange = 100; 
} else {
    $expensePercentageChange = 0; 
}

$conn->close();
?>

<!-- Financial Overview -->
<div class="row mb-4">
    <!-- Financial Summary Cards -->
    <div class="col-md-8">
        <div class="row">
            <!-- Total Income Card -->
            <div class="col-6 col-lg-3 mb-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-light-success text-success">
                            <i class='bx bx-dollar'></i>
                        </div>
                        <h6 class="card-subtitle mb-1 text-muted">Income</h6>
                        <h4 class="card-title mb-0">$<?= number_format($totalIncome, 2) ?></h4>
                        <small class="text-success"><i class='bx bx-up-arrow-alt'></i> <?= number_format($savingsPercentage, 1) ?>% saved this month</small>
                    </div>
                </div>
            </div>

            <!-- Total Expense Card -->
            <div class="col-6 col-lg-3 mb-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-light-danger text-danger">
                            <i class='bx bx-shopping-bag'></i>
                        </div>
                        <h6 class="card-subtitle mb-1 text-muted">Expenses</h6>
                        <h4 class="card-title mb-0">$<?= number_format($totalExpense, 2) ?></h4>
                        <small class="text-danger"><i class='bx bx-down-arrow-alt'></i> <?= number_format($expensePercentageChange, 1) ?>% from last month</small>
                    </div>
                </div>
            </div>

            <!-- Savings Card -->
            <div class="col-6 col-lg-3 mb-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="250">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-light-primary text-primary">
                            <i class='bx bx-wallet'></i>
                        </div>
                        <h6 class="card-subtitle mb-1 text-muted">Savings</h6>
                        <h4 class="card-title mb-0">$<?= number_format($savings, 2) ?></h4>
                        <small class="text-muted"><?= number_format($savingsPercentage, 1) ?>% of Income</small>
                    </div>
                </div>
            </div>
            <!-- Budget Card -->
            <div class="col-6 col-lg-3 mb-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-light-warning text-warning">
                            <i class='bx bx-pie-chart-alt'></i>
                        </div>
                        <h6 class="card-subtitle mb-1 text-muted">Budget</h6>
                        <h4 class="card-title mb-0"><?= number_format($budgetPercent, 0) ?>%</h4>
                        <small class="text-muted">$<?= number_format($budgetSpent, 2) ?> of $<?= number_format($monthlyBudget, 2) ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Chart -->
        <div class="container mt-5">
            <div class="chart-container" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="350">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Financial Overview</h5>
                    <div>
                        <select id="rangeSelect" class="form-select w-auto mb-3">
                            <option value="1" selected>Last 1 day</option>
                            <option value="3">Last 3 days</option>
                            <option value="5">Last 5 days</option>
                            <option value="7">Last 7 days</option>
                            <option value="14">Last 14 days</option>
                            <option value="21">Last 21 days</option>
                            <option value="30">Last 30 days</option>
                        </select>
                    </div>
                </div>
                <div style="width:100%; height:max-content;">
                    <canvas id="overviewChart"></canvas>
                </div>
            </div>
        </div>


    </div>

    <!-- Recent Transactions and Budget Progress -->
    <div class="col-md-4">
        <!-- Recent Transactions -->
        <div class="card mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Recent Transactions</h5>
                    <a href="../form/index.php" class="text-primary" data-bs-toggle="tooltip" title="View All">View All</a>
                </div>

                <div class="transaction-item">
                    <div class="transaction-icon bg-light-danger">
                        <i class='bx bx-food-menu text-danger'></i>
                    </div>
                    <div class="transaction-details">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Grocery Shopping</h6>
                            <span class="transaction-amount amount-expense">-$85.20</span>
                        </div>
                        <span class="transaction-category">Food & Groceries</span>
                    </div>
                </div>

                <div class="transaction-item">
                    <div class="transaction-icon bg-light-primary">
                        <i class='bx bx-car text-primary'></i>
                    </div>
                    <div class="transaction-details">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Gas Station</h6>
                            <span class="transaction-amount amount-expense">-$45.50</span>
                        </div>
                        <span class="transaction-category">Transportation</span>
                    </div>
                </div>

                <div class="transaction-item">
                    <div class="transaction-icon bg-light-success">
                        <i class='bx bx-dollar text-success'></i>
                    </div>
                    <div class="transaction-details">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Salary Deposit</h6>
                            <span class="transaction-amount amount-income">+$2,750.00</span>
                        </div>
                        <span class="transaction-category">Income</span>
                    </div>
                </div>

                <div class="transaction-item">
                    <div class="transaction-icon bg-light-warning">
                        <i class='bx bx-coffee text-warning'></i>
                    </div>
                    <div class="transaction-details">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Coffee Shop</h6>
                            <span class="transaction-amount amount-expense">-$12.40</span>
                        </div>
                        <span class="transaction-category">Food & Drinks</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Progress -->
        <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="450">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Budget Overview</h5>
                    <a href="../form/income_index.php" class="text-primary" id="view-details" data-bs-toggle="tooltip" title="View Details">Details</a>
                </div>

                <div class="budget-progress">
                    <div class="d-flex justify-content-between">
                        <span>Food & Groceries</span>
                        <span>$350/$500</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: 70%"></div>
                    </div>
                </div>

                <div class="budget-progress">
                    <div class="d-flex justify-content-between">
                        <span>Transport</span>
                        <span>$125/$150</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: 83%"></div>
                    </div>
                </div>

                <div class="budget-progress">
                    <div class="d-flex justify-content-between">
                        <span>Entertainment</span>
                        <span>$175/$200</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: 87%"></div>
                    </div>
                </div>

                <div class="budget-progress">
                    <div class="d-flex justify-content-between">
                        <span>Utilities</span>
                        <span>$90/$150</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: 60%"></div>
                    </div>
                </div>

                <div class="budget-progress mb-0">
                    <div class="d-flex justify-content-between">
                        <span>Savings</span>
                        <span>$850/$1000</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>