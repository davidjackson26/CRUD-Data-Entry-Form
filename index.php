<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $doj = $_POST['doj'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO employees (name, age, date_of_joining, email, phone) VALUES ('$name', '$age', '$doj', '$email', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Employee added successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        form {
            width: 300px;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
        }
        button, a {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            background: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover, a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Employee Data Entry</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="number" name="age" placeholder="Enter Age" required>
        <input type="date" name="doj" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="text" name="phone" placeholder="Enter Phone" required>
        <button type="submit">Create</button>
    </form>

    <a href="view.php">View Employees</a>
</body>
</html>

