<!-- Add Income Form -->
<div class="card mb-4 dashboard-card" data-aos="fade-up" data-aos-duration="1000">
    <div class="card-body">
        <h5 class="card-title">Add Income</h5>
        <form id="incomeForm" action="../form/income_input.php" method="post">
            <div class="mb-3">
                <label for="incomeDate" class="form-label">Date</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                    <input type="date" class="form-control" id="incomeDate" name="incomeDate" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="incomeDescription" class="form-label">Description</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-pencil'></i></span>
                    <input type="text" class="form-control" id="incomeDescription" name="incomeDescription" placeholder="e.g., Monthly Salary" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="incomeCategory" class="form-label">Category</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-tag'></i></span>
                    <select class="form-select" id="incomeCategory" name="incomeCategory" required>
                        <option value="">Select Category</option>
                        <option value="salary">Salary</option>
                        <option value="freelance">Freelance</option>
                        <option value="investments">Investments</option>
                        <option value="gifts">Gifts</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="incomeAmount" class="form-label">Amount</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-dollar'></i></span>
                    <input type="number" step="0.01" class="form-control" id="incomeAmount" name="incomeAmount" placeholder="0.00" required>
                </div>
            </div>
            <button type="submit" data-bs-toggle="tooltip" title="Click to add a new income" class="btn btn-primary shadow"><i class='bx bx-plus'></i> Add Income</button>
        </form>
    </div>
</div>

<!-- Recent Transactions and Recent Income Side by Side -->
<div class="row mb-4">
<?php
require_once '../databases/db.php';

// Ambil 5 pemasukan terbaru dari user yang login
$sql = "SELECT income_date, description, category, amount FROM income WHERE user_id = ? ORDER BY income_date DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();


function getIconData($category)
{
    $icons = [
        'salary' => ['icon' => 'bx-dollar', 'color' => 'success'],
        'freelance' => ['icon' => 'bx-briefcase', 'color' => 'warning'],
        'investment' => ['icon' => 'bx-bar-chart', 'color' => 'info'],
        'gift' => ['icon' => 'bx-gift', 'color' => 'primary'],
    ];
    $cat = strtolower($category);
    return $icons[$cat] ?? ['icon' => 'bx-wallet', 'color' => 'secondary'];
}
?>
<div class="col-md-6 mb-4">
    <div class="card mb-4 dashboard-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recent Incomes</h5>
                <div class="icon-group">
                    <i class='bx bx-filter-alt text-primary me-2' data-bs-toggle="tooltip" title="Filter"></i>
                    <i class='bx bx-list-ul text-primary me-2' data-bs-toggle="tooltip" title="List View"></i>
                    <i class='bx bx-refresh text-primary' data-bs-toggle="tooltip" title="Refresh"></i>
                </div>
            </div>

            <!-- Scrollable wrapper -->
            <div class="transaction-list" style="max-height: 320px; overflow-y: auto;">
                <?php while ($row = $result->fetch_assoc()):
                    $iconData = getIconData($row['category']);
                    $bgClass = "bg-light-" . $iconData['color'];
                    $textColor = "text-" . $iconData['color'];
                ?>
                    <div class="transaction-item">
                        <div class="transaction-icon <?= $bgClass ?>">
                            <i class='bx <?= $iconData['icon'] ?> <?= $textColor ?>'></i>
                        </div>
                        <div class="transaction-details">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0"><?= htmlspecialchars($row['description']) ?></h6>
                                <span class="transaction-amount amount-income">+<?= number_format($row['amount'], 2) ?></span>
                            </div>
                            <span class="transaction-category"><?= htmlspecialchars($row['category']) ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- End Scrollable -->
        </div>
    </div>
</div>
<?php
require_once '../databases/db.php';

$userId = $_SESSION['user_id'];
$sql = "SELECT description, category, amount FROM income WHERE user_id = ? ORDER BY income_date DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="col-md-6 mb-4">
    <!-- Recent Income -->
    <div class="card mb-4 dashboard-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recent Income</h5>
                <div class="icon-group">
                    <i class='bx bx-filter-alt text-primary me-2' data-bs-toggle="tooltip" title="Filter"></i>
                    <i class='bx bx-list-ul text-primary me-2' data-bs-toggle="tooltip" title="List View"></i>
                    <i class='bx bx-refresh text-primary' data-bs-toggle="tooltip" title="Refresh"></i>
                </div>
            </div>

            <!-- List Income dari DB -->
            <div class="transaction-list" style="max-height: 320px; overflow-y: auto;">
                <?php while ($row = $result->fetch_assoc()):
                    $icon = getIconData($row['category']);
                ?>
                    <div class="transaction-item">
                        <div class="transaction-icon bg-light-<?= $icon['color'] ?>">
                            <i class='bx <?= $icon['icon'] ?> text-<?= $icon['color'] ?>'></i>
                        </div>
                        <div class="transaction-details">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0"><?= htmlspecialchars($row['description']) ?></h6>
                                <span class="transaction-amount amount-income">+<?= number_format($row['amount'], 2) ?></span>
                            </div>
                            <span class="transaction-category"><?= htmlspecialchars($row['category']) ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
    <style>
        .transaction-list::-webkit-scrollbar {
            display: none;
        }


        .transaction-list {
            scrollbar-width: none;
        }
    </style>
</div>



<?php
require_once '../databases/db.php';

$userId = $_SESSION['user_id'];
$sql = "SELECT id, income_date, description, category, amount FROM income WHERE user_id = ? ORDER BY income_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>


<div class="row mt-4">
    <div class="col-12">
        <div class="card dashboard-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="550">
            <div class="card-body">
                <h5 class="card-title">Income List</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover shadow">
                        <thead>
                            <tr>
                                <th><i class='bx bx-calendar'></i> Date</th>
                                <th><i class='bx bx-text'></i> Description</th>
                                <th><i class='bx bx-tag'></i> Category</th>
                                <th><i class='bx bx-dollar'></i> Amount</th>
                                <th><i class='bx bx-cog'></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['income_date']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td><?= htmlspecialchars($row['category']) ?></td>
                                    <td>+<?= number_format($row['amount'], 2) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-2 edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="tooltip" title="Edit Income">
                                            <i class='bx bx-edit'></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger remove-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="tooltip" title="Remove Income">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if ($result->num_rows === 0): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No income records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


</div><!-- Income Modal -->
<div class="modal fade" id="incomeModal" tabindex="-1" aria-labelledby="incomeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 350px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incomeModalLabel">
                    <i class="bx bx-edit"></i> Edit Income
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form inside Modal -->
                <form id="income-form" action="../form/proses_edit_income.php" method="POST">
                    <input type="hidden" name="income_id" id="income_id" value="">
                    <div class="mb-3">
                        <label for="income_date" class="form-label">Date</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" class="form-control" name="income_date" id="income_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            <input type="text" class="form-control" name="description" id="description" placeholder="e.g., Monthly Salary" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-tag"></i></span>
                            <select class="form-select" name="category" id="category" required>
                                <option value="Salary">Salary</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Investments">Investments</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                            <input type="number" class="form-control" name="amount" id="amount" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>
                    <button type="submit" data-bs-toggle="tooltip" title="Save Changes" class="btn btn-primary shadow"><i class="bx bx-save"></i> Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
