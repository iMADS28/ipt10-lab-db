<?php
require_once 'config.php';

$id = trim($_GET['id'] ?? '');

if ($id === '') {
    die('Invalid student ID');
}

$s = $pdo->prepare(
    'SELECT first_name, last_name FROM students WHERE id = ?'
);

$s->execute([$id]);

$r = $s->fetch();

if (!$r) {
    echo '<p>Student not found.</p>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $d = $pdo->prepare(
        'DELETE FROM students WHERE id = ?'
    );

    $d->execute([$id]);

    if ($d->rowCount() > 0) {
        echo '<p>Student deleted successfully.</p>';
    } else {
        echo '<p>Failed to delete student.</p>';
    }

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