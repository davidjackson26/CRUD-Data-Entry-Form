<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

$id = "";
$name = "";
$age = "";
$doj = "";
$email = "";
$phone = "";
$created = false;
$errors = ["name" => "", "email" => "", "phone" => ""];

// Editing existing employee
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM employees WHERE id=$id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $age = $row['age'];
        $doj = $row['date_of_joining'];
        $email = $row['email'];
        $phone = $row['phone'];
    }
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $age = $_POST['age'];
    $doj = $_POST['doj'];
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $hasError = false;

    // Check duplicates (ignore current ID if updating)
    if (!empty($name)) {
        $check = $conn->query("SELECT id FROM employees WHERE name='$name' " . ($id ? "AND id!=$id" : ""));
        if ($check->num_rows > 0) {
            $errors['name'] = "Name already exists!";
            $hasError = true;
        }
    }

    if (!empty($email)) {
        $check = $conn->query("SELECT id FROM employees WHERE email='$email' " . ($id ? "AND id!=$id" : ""));
        if ($check->num_rows > 0) {
            $errors['email'] = "Email already exists!";
            $hasError = true;
        }
    }

    if (!empty($phone)) {
        $check = $conn->query("SELECT id FROM employees WHERE phone='$phone' " . ($id ? "AND id!=$id" : ""));
        if ($check->num_rows > 0) {
            $errors['phone'] = "Phone already exists!";
            $hasError = true;
        }
    }

    if (!$hasError) {
        if (!empty($id)) {
            $sql = "UPDATE employees SET 
                    name='$name', age='$age', date_of_joining='$doj',
                    email='$email', phone='$phone'
                    WHERE id=$id";
            $conn->query($sql);
            header("Location: view.php?updated=1");
            exit();
        } else {
            $sql = "INSERT INTO employees (name, age, date_of_joining, email, phone) 
                    VALUES ('$name','$age','$doj','$email','$phone')";
            if ($conn->query($sql)) {
                $created = true;
                $name = $age = $doj = $email = $phone = ""; // clear fields after insert
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Entry</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form input {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        form input:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 6px rgba(0,123,255,0.3);
        }
        .error {
            border: 1px solid red !important;
            background: #ffe6e6;
        }
        .error-msg {
            color: red;
            font-size: 12px;
            margin-top: -6px;
            margin-bottom: 6px;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .btn {
            flex: 1;
            text-align: center;
            padding: 12px;
            margin: 5px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-primary { background: #007BFF; color: #fff; }
        .btn-primary:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; color: #fff; }
        .btn-secondary:hover { background: #5a6268; }

        /* Snackbar */
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 14px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-size: 15px;
        }
        #snackbar.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @keyframes fadein { from {bottom:0; opacity:0;} to {bottom:30px; opacity:1;} }
        @keyframes fadeout { from {bottom:30px; opacity:1;} to {bottom:0; opacity:0;} }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo $id ? "Update Employee" : "Add New Employee"; ?></h2>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <input type="text" name="name" placeholder="Enter Name" 
                   value="<?php echo htmlspecialchars($name); ?>" 
                   class="<?php echo $errors['name'] ? 'error' : ''; ?>" required>
            <?php if ($errors['name']): ?><div class="error-msg"><?php echo $errors['name']; ?></div><?php endif; ?>

            <input type="number" name="age" placeholder="Enter Age" value="<?php echo htmlspecialchars($age); ?>" required>

            <input type="date" name="doj" value="<?php echo htmlspecialchars($doj); ?>" required>

            <input type="email" name="email" placeholder="Enter Email" 
                   value="<?php echo htmlspecialchars($email); ?>" 
                   class="<?php echo $errors['email'] ? 'error' : ''; ?>" required>
            <?php if ($errors['email']): ?><div class="error-msg"><?php echo $errors['email']; ?></div><?php endif; ?>

            <input type="text" name="phone" placeholder="Enter Phone" 
                   value="<?php echo htmlspecialchars($phone); ?>" 
                   class="<?php echo $errors['phone'] ? 'error' : ''; ?>" required>
            <?php if ($errors['phone']): ?><div class="error-msg"><?php echo $errors['phone']; ?></div><?php endif; ?>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary"><?php echo $id ? "Update" : "Create"; ?></button>
                <a href="view.php" class="btn btn-secondary">View</a>
            </div>
        </form>
    </div>

    <!-- Snackbar -->
    <div id="snackbar">Employee detail is created</div>

    <script>
        <?php if ($created): ?>
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        <?php endif; ?>
    </script>
</body>
</html>
