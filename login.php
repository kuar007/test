<?php
$conn = new mysqli("localhost", "root", "", "test");

session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    
    $stmt = $conn->prepare("SELECT * FROM form WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result(); 

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc(); 
        $_SESSION["form_id"] = $row["id"];
        $_SESSION["form_name"] = $row["name"]; 
        header("Location: redirect.php");
    } else {
        $message = "<p style='color:red;'>Invalid email or password.</p>";
    }

}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login Form</h2>
    <?php echo $message; ?>
    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
        
    </form>
       <p>New user? <a href="zscaler.php">Register here</a></p>
</body>
</html>