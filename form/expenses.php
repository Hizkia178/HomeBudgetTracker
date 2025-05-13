<!-- Add Expense Form -->
<div class="card mb-4" data-aos="fade-up" data-aos-duration="1000">
    <div class="card-body">
        <h5 class="card-title">Add Expense</h5>
        <form id="expenseForm" action="../form/expenses_input.php" method="post">
            <div class="mb-3">
                <label for="expenseDate" class="form-label">Date</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                    <input type="date" class="form-control" id="expenseDate" name="expenseDate" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="expenseDescription" class="form-label">Description</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-pencil'></i></span>
                    <input type="text" class="form-control" id="expenseDescription" name="expenseDescription" placeholder="e.g., Grocery Shopping" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="expenseCategory" class="form-label">Category</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-tag'></i></span>
                    <select class="form-select" id="expenseCategory" name="expenseCategory" required>
                        <option value="">Select Category</option>
                        <option value="food">Food & Groceries</option>
                        <option value="transport">Transportation</option>
                        <option value="entertainment">Entertainment</option>
                        <option value="utilities">Utilities</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="expenseAmount" class="form-label">Amount</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-dollar'></i></span>
                    <input type="number" step="0.01" class="form-control" id="expenseAmount" name="expenseAmount" placeholder="0.00" required>
                </div>
            </div>
            <button type="submit" data-bs-toggle="tooltip" title="Click to add a new expense" class="btn btn-primary shadow"><i class='bx bx-plus'></i> Add Expense</button>
        </form>
    </div>
</div>

<!-- Recent Transactions and Recent Expenses Side by Side -->
<div class="row mb-4">
<?php
require_once '../databases/db.php';

// Function to get icon and color based on category (similar to income code)
function getIconData($category)
{
    $icons = [
        'salary' => ['icon' => 'bx-dollar', 'color' => 'success'],
        'freelance' => ['icon' => 'bx-briefcase', 'color' => 'warning'],
        'investment' => ['icon' => 'bx-bar-chart', 'color' => 'info'],
        'gift' => ['icon' => 'bx-gift', 'color' => 'primary'],
    ];
    $cat = strtolower($category);
    return $icons[$cat] ?? ['icon' => 'bx-wallet', 'color' => 'secondary'];  // Default icon if category doesn't match
}

?>

<div class="col-md-6 mb-4">
    <!-- Recent Transactions -->
    <div class="card mb-4 dashboard-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recent Transactions</h5>
                <div class="icon-group">
                    <i class='bx bx-filter-alt text-primary me-2' data-bs-toggle="tooltip" title="Filter"></i>
                    <i class='bx bx-list-ul text-primary me-2' data-bs-toggle="tooltip" title="List View"></i>
                    <i class='bx bx-refresh text-primary' data-bs-toggle="tooltip" title="Refresh"></i>
                </div>
            </div>

            <div class="transaction-list" style="max-height: 350px; overflow-y: scroll;">
                <?php
                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Get latest 5 expenses from the database
                    $stmt = $conn->prepare("SELECT description, amount, category FROM expenses WHERE user_id = ? ORDER BY expense_date DESC LIMIT 5");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Get icon and color for the category
                            $iconData = getIconData($row['category']);
                            $bgClass = "bg-light-" . $iconData['color'];
                            $textColor = "text-" . $iconData['color'];
                            $amountClass = ($row['amount'] < 0) ? 'amount-expense' : 'amount-income';

                            echo "
                                <div class='transaction-item'>
                                    <div class='transaction-icon $bgClass'>
                                        <i class='bx {$iconData['icon']} {$textColor}'></i>
                                    </div>
                                    <div class='transaction-details'>
                                        <div class='d-flex justify-content-between'>
                                            <h6 class='mb-0'>{$row['description']}</h6>
                                            <span class='transaction-amount $amountClass'>" . ($row['amount'] < 0 ? '-' : '+') . number_format(abs($row['amount']), 2) . "</span>
                                        </div>
                                        <span class='transaction-category'>{$row['category']}</span>
                                    </div>
                                </div>
                            ";
                        }
                    } else {
                        echo "Tidak ada transaksi ditemukan.";
                    }

                    $stmt->close();
                } else {
                    echo "Silakan login untuk melihat transaksi Anda.";
                }
                ?>
            </div>
        </div>
    </div>
</div>



<?php
require_once '../databases/db.php';
?>

<div class="col-md-6 mb-4">
    <!-- Recent Expenses -->
    <div class="card mb-4 dashboard-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recent Expenses</h5>
                <div class="icon-group">
                    <i class='bx bx-filter-alt text-primary me-2' data-bs-toggle="tooltip" title="Filter"></i>
                    <i class='bx bx-list-ul text-primary me-2' data-bs-toggle="tooltip" title="List View"></i>
                    <i class='bx bx-refresh text-primary' data-bs-toggle="tooltip" title="Refresh"></i>
                </div>
            </div>

            <div class="transaction-list" style="max-height: 350px; overflow-y: scroll;">
                <?php
                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Get latest 5 expenses from the database
                    $stmt = $conn->prepare("SELECT description, amount, category FROM expenses WHERE user_id = ? ORDER BY expense_date DESC LIMIT 5");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Get icon and color for the category
                            $iconData = getIconData($row['category']);
                            $bgClass = "bg-light-" . $iconData['color'];
                            $textColor = "text-" . $iconData['color'];
                            $amountClass = ($row['amount'] < 0) ? 'amount-expense' : 'amount-income';

                            echo "
                                <div class='transaction-item'>
                                    <div class='transaction-icon $bgClass'>
                                        <i class='bx {$iconData['icon']} {$textColor}'></i>
                                    </div>
                                    <div class='transaction-details'>
                                        <div class='d-flex justify-content-between'>
                                            <h6 class='mb-0'>{$row['description']}</h6>
                                            <span class='transaction-amount $amountClass'>" . ($row['amount'] < 0 ? '-' : '+') . number_format(abs($row['amount']), 2) . "</span>
                                        </div>
                                        <span class='transaction-category'>{$row['category']}</span>
                                    </div>
                                </div>
                            ";
                        }
                    } else {
                        echo "Tidak ada transaksi ditemukan.";
                    }

                    $stmt->close();
                } else {
                    echo "Silakan login untuk melihat transaksi Anda.";
                }
                ?>
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
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT id, expense_date, description, category, amount FROM expenses WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!-- Expenses Table -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card dashboard-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="550">
            <div class="card-body">
                <h5 class="card-title">Expenses List</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover shadow">
                        <thead>
                            <tr>
                                <th><i class='bx bx-calendar'></i> Date</th>
                                <th><i class='bx bx-text'></i> Description</th>
                                <th><i class='bx bx-tag'></i> Category</th>
                                <th><i class='bx bx-dollar'></i> Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // cek jika ada banyak expense
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // hasil output
                                    echo "
                                    <tr>
                                        <td>{$row['expense_date']}</td>
                                        <td>{$row['description']}</td>
                                        <td>{$row['category']}</td>
                                        <td>" . number_format($row['amount'], 2) . "</td>
                                        <td>
                                                <button class='btn btn-sm btn-outline-primary me-2 edit-btn' data-id='{$row['id']}' data-description='{$row['description']}' data-category='{$row['category']}' data-amount='{$row['amount']}' data-bs-toggle='tooltip' title='Edit Data'><i class='bx bx-edit'></i></button>
                                                <button class='btn btn-sm btn-outline-danger delete-btn' data-id='{$row['id']}' data-bs-toggle='tooltip' title='Remove Data'><i class='bx bx-trash'></i></button>
                                        </td>
                                    </tr>
                                    ";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No expenses found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 350px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="expenseModalLabel">
                    <i class="bx bx-edit"></i> Edit Expense
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form inside Modal -->
                <form id="expense-form" action="../form/proses_edit_expenses.php" method="POST">
                    <input type="hidden" name="expense_id" id="expense_id" value="">
                    <div class="mb-3">
                        <label for="expense_date" class="form-label">Date</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" class="form-control" name="expense_date" id="expense_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            <input type="text" class="form-control" name="description" id="description" placeholder="e.g., Grocery Shopping" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-tag"></i></span>
                            <select class="form-select" name="category" id="category" required>
                                <option value="Food & Groceries">Food & Groceries</option>
                                <option value="Transportation">Transportation</option>
                                <option value="Food & Drinks">Food & Drinks</option>
                                <option value="Income">Income</option>
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
                    <button type="submit" data-bs-toggle="tooltip" title="Change Data" class="btn btn-primary shadow"><i class="bx bx-save"></i> Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
