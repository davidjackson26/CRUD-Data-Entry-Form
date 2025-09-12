<?php
include 'config.php';

$id = "";
$name = "";
$age = "";
$doj = "";
$email = "";
$phone = "";
$created = false; 


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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $doj = $_POST['doj'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (!empty($id)) {
        
        $sql = "UPDATE employees SET 
                name='$name', 
                age='$age', 
                date_of_joining='$doj', 
                email='$email', 
                phone='$phone' 
                WHERE id=$id";
        $conn->query($sql);
        header("Location: view.php?updated=1");
        exit();
    } else {
        
        $sql = "INSERT INTO employees (name, age, date_of_joining, email, phone) 
                VALUES ('$name', '$age', '$doj', '$email', '$phone')";
        if ($conn->query($sql)) {
            $created = true; 
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Entry</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { width: 300px; margin-bottom: 20px; }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button, a {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            border: none;
            background: #007BFF;
            color: white;
            text-decoration: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover, a:hover { background: #0056b3; }

        #snackbar {
            visibility: hidden;
            min-width: 250px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 12px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-size: 16px;
        }
        #snackbar.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @keyframes fadein {
            from { bottom: 0; opacity: 0; } 
            to { bottom: 30px; opacity: 1; }
        }
        @keyframes fadeout {
            from { bottom: 30px; opacity: 1; } 
            to { bottom: 0; opacity: 0; }
        }
    </style>
</head>
<body>
    <h2><?php echo $id ? "Update Employee" : "Add New Employee"; ?></h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="name" placeholder="Enter Name" value="<?php echo $name; ?>" required>
        <input type="number" name="age" placeholder="Enter Age" value="<?php echo $age; ?>" required>
        <input type="date" name="doj" value="<?php echo $doj; ?>" required>
        <input type="email" name="email" placeholder="Enter Email" value="<?php echo $email; ?>" required>
        <input type="text" name="phone" placeholder="Enter Phone" value="<?php echo $phone; ?>" required>
        <button type="submit"><?php echo $id ? "Update" : "Create"; ?></button>
    </form>

    <a href="view.php">View Employees</a>
    
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
