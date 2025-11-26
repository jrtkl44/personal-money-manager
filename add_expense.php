<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $amount = $_POST['amount'];
    $category = sanitize($_POST['category']);
    $type = $_POST['type'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO expenses (user_id, title, amount, category, type, date) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $title, $amount, $category, $type, $date])) {
        redirect('dashboard.php');
    } else {
        $error = "Failed to add entry.";
    }
}
?>

<div class="auth-box" style="max-width: 600px;">
    <h2>Add New Transaction</h2>
    <br>
    
    <form action="" method="POST">
        <div class="form-group">
            <label>Transaction Type</label>
            <select name="type" class="form-control" required>
                <option value="expense">Expense (খরচ)</option>
                <option value="income">Income (আয়)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Title </label>
            <input type="text" name="title" class="form-control" placeholder="Ex: Grocery, Salary" required>
        </div>

        <div class="form-group">
            <label>Amount (TK)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category" class="form-control" required>
                <option value="Food">Food</option>
                <option value="Transport">Transport</option>
                <option value="Utilities">Utilities</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Salary">Salary</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit" class="btn">Save Transaction</button>
        <br><br>
        <a href="dashboard.php" style="color: #636e72;">Back to Dashboard</a>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>