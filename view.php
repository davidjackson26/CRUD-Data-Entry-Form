<?php
include 'config.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM employees WHERE id=$id");
    header("Location: view.php?deleted=1");
    exit();
}

$result = $conn->query("SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        th {
            background: #007BFF;
            color: #fff;
            font-weight: 600;
        }

        tr:hover {
            background: #f1f5fb;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
            margin: 2px;
        }

        .btn-update {
            background: #28a745;
            color: #fff;
        }

        .btn-update:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
            color: #fff;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-back {
            background: #6c757d;
            color: #fff;
        }

        .btn-back:hover {
            background: #5a6268;
        }

    
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            background-color: #17a2b8;
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
        <h2>Employee List</h2>

        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Age</th><th>Date of Joining</th><th>Email</th><th>Phone</th><th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['age']; ?></td>
                <td><?= $row['date_of_joining']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['phone']; ?></td>
                <td>
                    <a href="index.php?id=<?= $row['id']; ?>" class="btn btn-update">Update</a>
                    <a href="view.php?delete=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div style="text-align:center;">
            <a href="index.php" class="btn btn-back">Back</a>
        </div>
    </div>

    <div id="snackbar">Action completed successfully</div>

    <script>
        
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('deleted')) {
            var x = document.getElementById("snackbar");
            x.innerText = "Employee deleted successfully";
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
        if (urlParams.has('updated')) {
            var x = document.getElementById("snackbar");
            x.innerText = "Employee updated successfully";
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
    </script>
</body>
</html>	
