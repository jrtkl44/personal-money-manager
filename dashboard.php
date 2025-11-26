<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    redirect('index.php');
}

$user_id = $_SESSION['user_id'];

// Fetch Totals
// Income
$stmt = $pdo->prepare("SELECT SUM(amount) as total FROM expenses WHERE user_id = ? AND type = 'income'");
$stmt->execute([$user_id]);
$income = $stmt->fetch()['total'] ?? 0;

// Expense
$stmt = $pdo->prepare("SELECT SUM(amount) as total FROM expenses WHERE user_id = ? AND type = 'expense'");
$stmt->execute([$user_id]);
$expense = $stmt->fetch()['total'] ?? 0;

// Balance
$balance = $income - $expense;

// Fetch Recent Transactions
$stmt = $pdo->prepare("SELECT * FROM expenses WHERE user_id = ? ORDER BY date DESC LIMIT 10");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <a href="add_expense.php" class="btn" style="width: auto;">+ Add New</a>
</div>

<!-- Cards -->
<div class="dashboard-grid">
    <div class="card income-card">
        <div>
            <h3>Total Income</h3>
            <p><?php echo formatMoney($income); ?></p>
        </div>
        <i class="fa-solid fa-arrow-trend-up fa-2x" style="color: var(--success);"></i>
    </div>
    
    <div class="card expense-card">
        <div>
            <h3>Total Expense</h3>
            <p><?php echo formatMoney($expense); ?></p>
        </div>
        <i class="fa-solid fa-arrow-trend-down fa-2x" style="color: var(--danger);"></i>
    </div>

    <div class="card balance-card">
        <div>
            <h3>Current Balance</h3>
            <p><?php echo formatMoney($balance); ?></p>
        </div>
        <i class="fa-solid fa-wallet fa-2x" style="color: var(--primary);"></i>
    </div>
</div>

<!-- Transaction List -->
<div class="recent-transactions">
    <h3>Recent Transactions</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($transactions) > 0): ?>
                    <?php foreach($transactions as $t): ?>
                        <tr>
                            <td><?php echo date('d M, Y', strtotime($t['date'])); ?></td>
                            <td><?php echo htmlspecialchars($t['title']); ?></td>
                            <td><span class="developer-pill" style="font-size: 0.8rem;"><?php echo htmlspecialchars($t['category']); ?></span></td>
                            <td style="color: <?php echo $t['type'] == 'income' ? 'var(--success)' : 'var(--danger)'; ?>; font-weight: bold; text-transform: capitalize;">
                                <?php echo $t['type']; ?>
                            </td>
                            <td style="font-weight: 600;">
                                <?php echo ($t['type'] == 'expense' ? '-' : '+') . formatMoney($t['amount']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No transactions found. Add one!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>