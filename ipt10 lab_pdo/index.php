<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require_once 'config.php';

$sql = 'SELECT id, first_name, last_name, email, enrolment_date
        FROM students
        ORDER BY enrolment_date DESC, id DESC';

$rows = $pdo->query($sql)->fetchAll();
?>

<h2>All Student Records</h2>

<a href="create.php" class="create-btn">Create Student</a>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Enrolled</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php foreach ($rows as $row): ?>
<tr>
    <td><?= htmlspecialchars($row['id']) ?></td>

    <td>
        <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
    </td>

    <td><?= htmlspecialchars($row['email']) ?></td>

    <td><?= htmlspecialchars($row['enrolment_date']) ?></td>

    <td class="actions">
    <a href="view.php?id=<?= htmlspecialchars($row['id']) ?>" class="action-btn view-btn">
        View
    </a>

    <a href="edit.php?id=<?= htmlspecialchars($row['id']) ?>" class="action-btn edit-btn">
        Edit
    </a>

    <a href="delete.php?id=<?= htmlspecialchars($row['id']) ?>"
       class="action-btn delete-btn"
       onclick="return confirm('Are you sure?')">
        Delete
    </a>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

</body>
</html>