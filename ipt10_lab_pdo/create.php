<?php

require_once 'config.php';

$errors = [];

$first_name = '';
$middle_name = '';
$last_name = '';
$email = '';
$birthday = '';
$sex = '';
$student_number = '';
$program = '';
$enrolment_date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = trim($_POST['first_name'] ?? '');
    $middle_name = trim($_POST['middle_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $student_number = trim($_POST['student_number'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $enrolment_date = trim($_POST['enrolment_date'] ?? '');

    if (
        empty($first_name) ||
        strlen($first_name) < 2 ||
        strlen($first_name) > 100 ||
        !preg_match('/^[A-Za-z\s]+$/', $first_name)
    ) {
        $errors['first_name'] =
            'First name is required and must be 2-100 characters using letters and spaces only.';
    }

    if (
        empty($last_name) ||
        strlen($last_name) < 2 ||
        strlen($last_name) > 100 ||
        !preg_match('/^[A-Za-z\s]+$/', $last_name)
    ) {
        $errors['last_name'] =
            'Last name is required and must be 2-100 characters using letters and spaces only.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
        $errors['birthday'] = 'Birthday must be in YYYY-MM-DD format.';
    }

    if (!in_array($sex, ['Male', 'Female'], true)) {
        $errors['sex'] = 'Sex must be Male or Female.';
    }

    if (empty($errors)) {

        $sql = 'INSERT INTO students
                (id, first_name, middle_name, last_name, birthday, sex, email,
                 student_number, program, enrolment_date)
                VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $first_name,
            $middle_name,
            $last_name,
            $birthday,
            $sex,
            $email,
            $student_number,
            $program,
            $enrolment_date
        ]);

        if ($stmt->rowCount() > 0) {
            $success = 'Student created successfully.';

            $first_name = '';
            $middle_name = '';
            $last_name = '';
            $email = '';
            $birthday = '';
            $sex = '';
            $student_number = '';
            $program = '';
            $enrolment_date = '';
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Add New Student</h2>

<?php if (isset($success)): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<div class="form-container">

    <form method="post">

        <div class="form-group">
            <label>First Name:</label>
            <input
                type="text"
                name="first_name"
                value="<?= htmlspecialchars($first_name) ?>"
            >

            <?php if (isset($errors['first_name'])): ?>
                <div class="error">
                    <?= htmlspecialchars($errors['first_name']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Middle Name:</label>
            <input
                type="text"
                name="middle_name"
                value="<?= htmlspecialchars($middle_name) ?>"
            >
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input
                type="text"
                name="last_name"
                value="<?= htmlspecialchars($last_name) ?>"
            >

            <?php if (isset($errors['last_name'])): ?>
                <div class="error">
                    <?= htmlspecialchars($errors['last_name']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Birthday:</label>
            <input
                type="date"
                name="birthday"
                value="<?= htmlspecialchars($birthday) ?>"
            >

            <?php if (isset($errors['birthday'])): ?>
                <div class="error">
                    <?= htmlspecialchars($errors['birthday']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Sex:</label>

            <select name="sex">
                <option value="">Select Sex</option>

                <option value="Male" <?= $sex === 'Male' ? 'selected' : '' ?>>
                    Male
                </option>

                <option value="Female" <?= $sex === 'Female' ? 'selected' : '' ?>>
                    Female
                </option>
            </select>

            <?php if (isset($errors['sex'])): ?>
                <div class="error">
                    <?= htmlspecialchars($errors['sex']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Email:</label>

            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($email) ?>"
            >

            <?php if (isset($errors['email'])): ?>
                <div class="error">
                    <?= htmlspecialchars($errors['email']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Student Number:</label>

            <input
                type="text"
                name="student_number"
                value="<?= htmlspecialchars($student_number) ?>"
            >
        </div>

        <div class="form-group">
            <label>Program:</label>

            <input
                type="text"
                name="program"
                value="<?= htmlspecialchars($program) ?>"
            >
        </div>

        <div class="form-group">
            <label>Enrolment Date:</label>

            <input
                type="date"
                name="enrolment_date"
                value="<?= htmlspecialchars($enrolment_date) ?>"
            >
        </div>

        <div class="form-buttons">

            <button type="submit" class="submit-btn">
                Create Student
            </button>

            <a href="index.php" class="cancel-btn">
                Cancel
            </a>

        </div>

    </form>

</div>

</body>
</html>