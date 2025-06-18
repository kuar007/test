<?php
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = $_POST["mobile"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 

   
    $check = $conn->prepare("SELECT * FROM student WHERE mobile = ?");
    $check->bind_param("s", $mobile);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<p style='color:red;'>Mobile already registered.</p>"; 
    } else {
    
        $stmt = $conn->prepare("INSERT INTO student (mobile, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $mobile, $password);

        if ($stmt->execute()) {
            $message = "signup successful!";

        } else {
            $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>mobile signup</title>
</head>
<body>
    <h2>signup</h2>
    <?php if($message != ''){

        echo $message;
    }  ?>
    <form method="POST" action="">
        <label>mobile:</label><br>
        <input type="text" name="mobile" required pattern="[0-9]{10}" title="Enter a 10-digit mobile number"><br><br>


        <label>password:</label><br>
        <input type="password" name="password" required ><br><br>

       

        <button type="submit">Register</button>
    </form>
</body>
</html>