<?php
require_once __DIR__ . '/includes/db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Shop With Me</title>
    <link rel="stylesheet" href="/shop-with-me/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <!-- Copy the header from your index.php -->
    <header>
        <nav class="navbar">
            <div class="nav-left">
                <h1>Shop With Me</h1>
            </div>
            <div class="nav-links">
                <a href="account.php">Account</a>
                <a href="logout.php">Logout</a>
                <!-- Rest of your navigation -->
            </div>
        </nav>
    </header>

    <main class="account-container">
        <h1>My Account</h1>
        <div class="account-info">
            <p><strong>Name:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
        
        <div class="account-actions">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </main>

    <!-- Copy the footer from your index.php -->
    <footer>
        <p>&copy; 2025 Shop With Me. All rights reserved.</p>
    </footer>
</body>
</html>