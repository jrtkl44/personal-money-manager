<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        $error = "Email already registered!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $password])) {
            $success = "Registration successful! You can login now.";
        } else {
            $error = "Something went wrong!";
        }
    }
}
?>

<div class="auth-box">
    <h2>Create Account</h2>
    <br>
    
    <?php if($error): ?>
        <p style="color: red; margin-bottom: 10px;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if($success): ?>
        <p style="color: green; margin-bottom: 10px;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
    
    <br>
    <p>Already have an account? <a href="index.php">Login Here</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>