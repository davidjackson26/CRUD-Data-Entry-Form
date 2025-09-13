<?php
include 'config.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); 
    $stmt = $conn->prepare("DELETE FROM employees WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: view.php?deleted=1");
    exit();
}

$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");
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
            position: sticky;
            top: 0;
            z-index: 1;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
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

        .btn-update { background: #28a745; color: #fff; }
        .btn-update:hover { background: #218838; }

        .btn-delete { background: #dc3545; color: #fff; }
        .btn-delete:hover { background: #c82333; }

        .btn-back { background: #6c757d; color: #fff; }
        .btn-back:hover { background: #5a6268; }

        
        #snackbar {
            visibility: hidden;
            min-width: 250px;
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

        
        .table-container {
            overflow-x: auto;
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Employee List</h2>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th><th>Name</th><th>Age</th><th>Date of Joining</th><th>Email</th><th>Phone</th><th>Actions</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['age']); ?></td>
                        <td><?= htmlspecialchars($row['date_of_joining']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['phone']); ?></td>
                        <td>
                            <a href="index.php?id=<?= $row['id']; ?>" class="btn btn-update">Update</a>
                            <a href="view.php?delete=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="no-data">No employees found. Please add some records.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <div style="text-align:center;">
            <a href="index.php" class="btn btn-back">Back</a>
        </div>
    </div>

    <div id="snackbar"></div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        let x = document.getElementById("snackbar");

        if (urlParams.has('deleted')) {
            x.innerText = "Employee deleted successfully";
            x.style.backgroundColor = "#dc3545";
            x.className = "show";
        } 
        if (urlParams.has('updated')) {
            x.innerText = "Employee updated successfully";
            x.style.backgroundColor = "#28a745";
            x.className = "show";
        }
        if (urlParams.has('created')) {
            x.innerText = "Employee created successfully";
            x.style.backgroundColor = "#007BFF";
            x.className = "show";
        }
        if (x.className === "show") {
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
    </script>
</body>
</html>
