<?php
session_start();
if (!isset($_SESSION['form_name'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>newpage</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['email']) ?>!</h2>
    <p>This is your newpage page.</p>
    <form method="POST" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>
</html>