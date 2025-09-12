<?php
include 'config.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM employees WHERE id=$id");
    header("Location: view.php");
    exit();
}

$result = $conn->query("SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #007BFF; color: white; }
        a.button {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            margin: 2px;
        }
        .update { background: #28a745; }
        .delete { background: #dc3545; }
        .back { background: #6c757d; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Employee List</h2>

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
                <a href="index.php?id=<?= $row['id']; ?>" class="button update">Update</a>
                <a href="view.php?delete=<?= $row['id']; ?>" class="button delete" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div style="text-align:center;">
        <a href="index.php" class="button back">Back</a>
    </div>
</body>
</html>


