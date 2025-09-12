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
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>	</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f9;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
            margin-bottom: 25px;
            color: #333;
        }

        form input {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s;
        }

        form input:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 6px rgba(0,123,255,0.3);
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
            transition: 0.3s;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: #007BFF;
            color: #fff;
        }
        .btn-primary:hover { background: #0056b3; }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }
        .btn-secondary:hover { background: #5a6268; }

        
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
    <div class="container">
        <h2><?php echo $id ? "Update Employee" : "Add New Employee"; ?></h2>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="name" placeholder="Enter Name" value="<?php echo $name; ?>" required>
            <input type="number" name="age" placeholder="Enter Age" value="<?php echo $age; ?>" required>
            <input type="date" name="doj" value="<?php echo $doj; ?>" required>
            <input type="email" name="email" placeholder="Enter Email" value="<?php echo $email; ?>" required>
            <input type="text" name="phone" placeholder="Enter Phone" value="<?php echo $phone; ?>" required>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary"><?php echo $id ? "Update" : "Create"; ?></button>
                <a href="view.php" class="btn btn-secondary">View</a>
            </div>
        </form>
    </div>

    
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
