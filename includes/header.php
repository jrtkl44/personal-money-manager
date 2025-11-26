<?php require_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eMS - Money Manager</title>
    <!-- CSS Link -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Favicon Placeholder -->
    <link rel="icon" href="assets/img/favicon.ico">
</head>
<body>

<header>
    <!-- Logo Section -->
    <a href="dashboard.php" class="logo-area">
        <!-- Replace src with your actual logo path -->
        <img src="assets/img/logo.png" alt="eMS" onerror="this.style.display='none'">
        <span>eMS</span>
    </a>

    <!-- Navigation -->
    <nav>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" style="margin-right: 15px; text-decoration: none; color: #2d3436;">Dashboard</a>
            <a href="logout.php" style="margin-right: 15px; text-decoration: none; color: #d63031;">Logout</a>
        <?php endif; ?>
        
        <!-- Developer Pill -->
        <a href="https://jrtkl.netlify.app/" target="_blank" class="developer-pill">
            <i class="fa-solid fa-arrow-up"></i> JR Torikul Islam
        </a>
    </nav>
</header>

<div class="container">