<?php
require_once 'db_connect.php';

$id = trim($_GET['id'] ?? '');
if ($id === '') {
    die('Invalid student ID');
}


$s = $conn->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$s->bind_param('s', $id);
$s->execute();

$r = $s->get_result()->fetch_assoc();
$s->close();

if (!$r) {
    echo '<p>Student not found.</p>';
    $conn->close();
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = $conn->prepare('DELETE FROM students WHERE id = ?');
    $d->bind_param('s', $id);
    $d->execute();

    if ($d->affected_rows > 0) {
        echo '<p>Student deleted successfully.</p>';
    } else {
        echo '<p>Failed to delete student.</p>';
    }

    $conn->close();
} else {
   
    echo '<h2>Delete Student</h2>';
    echo '<p>Are you sure you want to delete '
        . htmlspecialchars($r['first_name'] . ' ' . $r['last_name'])
        . '?</p>';

    echo '<form method="post">';
    echo '<input type="hidden" name="id" value="'
        . htmlspecialchars($id)
        . '">';
    echo '<button type="submit">Yes, Delete</button>';
    echo '</form>';

    echo '<p><a href="index.php">Cancel</a></p>';
}
?>