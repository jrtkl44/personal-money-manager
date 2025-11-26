<?php
// includes/functions.php

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function formatMoney($amount) {
    return number_format($amount, 2) . ' BDT';
}
?>