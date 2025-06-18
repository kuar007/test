<?php
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];
    $password = $_POST["password"];

     $check = $conn->prepare("SELECT * FROM form WHERE email = ? OR mobile = ?");
    $check->bind_param("ss", $email, $mobile);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<p style='color:red;'>Email or Mobile already registered.</p>";
    } else {

    $stmt = $conn->prepare("INSERT INTO form (firstname, lastname, mobile, email, password) VALUES 
    (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $mobile, $email, $password);

    if ($stmt->execute()) {
        $message = "<p style='color:green;'>Registration successful!</p>";
    } else {
        $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
    }

    
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Simple Signup</title>
</head>

<body>
    <h2>Signup Form</h2>
    <?php echo $message; ?>
    <form method="POST" action="">
        <label>First Name:</label><br>
        <input type="text" name="firstname" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="lastname" required><br><br>

        <label>Mobile Number:</label><br>
        <input type="text" name="mobile" required pattern="[0-9]{10}"
            title="Enter a valid 10-digit mobile number"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="text" name="password" required><br><br>

        <button type="submit">Register</button>

    </form>
    <p>Already registered? <a href="login.php">Login here</a></p>
</body>

</html>