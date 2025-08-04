<?php
require_once __DIR__ . '/includes/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop With Me</title>
    <link rel="stylesheet" href="/shop-with-me/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-left">
                <h1>Shop With Me</h1>
            </div>

            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="account.php">Account</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
                
                <div class="dropdown">
                    <button class="dropbtn">Offer <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="#">Family Pack</a>
                        <a href="#">Special Deal</a>
                        <a href="#">Seasonal Offer</a>
                    </div>
                </div>

                <a href="order.php" class="order-now-btn">Order Now</a>
            </div>
        </nav>
    </header>