<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        redirect('dashboard.php');
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<div class="auth-box">
    <h2>Login to eMS</h2>
    <p>Your personal money manager</p>
    <br>
    
    <?php if($error): ?>
        <p style="color: red; margin-bottom: 10px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
    
    <br>
    <p>Don't have an account? <a href="register.php">Register Here</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>