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