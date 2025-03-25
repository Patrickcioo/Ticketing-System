<?php
include 'db_connect.php';

$query = "SELECT * FROM concerns";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CTS - View Concerns</title>
    <link rel="icon" href="afppng.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .actions button {
            padding: 5px 10px;
            margin: 5px;
            border: none;
            cursor: pointer;
        }
        .pending { background: orange; color: white; }
        .ongoing { background: blue; color: white; }
        .finished { background: green; color: white; }
    </style>
</head>
<body>

<h2>Concerns List</h2>
<table>
    <thead>
        <tr>
            <th>Unit</th>
            <th>Description</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['unit']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td class="<?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['date']) ?></td>
                <td class="actions">
                    <form method="post" action="update_status.php" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button name="status" value="Pending" class="pending">Pending</button>
                        <button name="status" value="Ongoing" class="ongoing">Ongoing</button>
                        <button name="status" value="Finished" class="finished">Finished</button>
                    </form>
                    <form method="post" action="delete_concern.php" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button style="background: red; color: white;">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="index.html">Back to Home</a>

</body>
</html>

<?php
$conn->close();
?>
