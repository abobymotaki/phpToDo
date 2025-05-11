<?php
include 'connections/connection.php';
include_once 'connections/queries.php';

session_start();

$userHandling = $_POST["userHandling"] ?? null;

if ($userHandling === "login") {
    login($conn);
} elseif ($userHandling === "register") {
    register($conn);
}

function login($conn) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST["password"] ?? '';

    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$sql) {
        $_SESSION['message'] = 'Error preparing query: <p class="error-message">Error preparing query: </p>' . $conn->error;
        header("Location: ../frontend/src/auth/login.php");
        exit;
    }
    $sql->bind_param('s', $username);

    if (!$sql->execute()) {
        $_SESSION['message'] = '<p class="error-message">Error executing query: </p>' . $sql->error;
        $sql->close();
        header("Location: ../frontend/src/auth/login.php");
        exit;
    }

    $getPassword = $sql->get_result();
    if ($getPassword->num_rows === 0) {
        $_SESSION['message'] = '<p class="error-message">Invalid Username!</p>';
        $sql->close();
        header("Location: ../frontend/src/auth/login.php");
        exit;
    }

    $row = $getPassword->fetch_assoc();
    $hashed_password = $row['password'];
    $userID = $row['id'];

    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $userID;
        header("Location: ../frontend/src/views/dashboard.php");
        exit;
    } else {
        $_SESSION['message'] = '<p class="error-message">Invalid Password!</p>';
        header("Location: ../frontend/src/auth/login.php");
        exit;
    }

    $sql->close();
}

function register($conn) {
    $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = '<p class="error-message">Invalid email format.</p>';
        header("Location: ../frontend/src/auth/register.php");
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['message'] = '<p class="error-message">Password must be at least 8 characters long.<p>';
        header("Location: ../frontend/src/auth/register.php");
        exit;
    }

    $sql = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    if (!$sql) {
        $_SESSION['message'] = '<p class="error-message">Error preparing query: ' . $conn->error . '</p>';
        header("Location: ../frontend/src/auth/register.php");
        exit;
    }
    $sql->bind_param('ss', $username, $email);

    if (!$sql->execute()) {
        $_SESSION['message'] = '<p class="error-message">Error executing query: ' . $sql->error . '</p>';
        $sql->close();
        header("Location: ../frontend/src/auth/register.php");
        exit;
    }

    $result = $sql->get_result();
    if ($result->num_rows >= 1) {
        $_SESSION['message'] = '<p class="error-message">Username/Email is already taken. Please choose a different username.<p>';
        $sql->close();
        header("Location: ../frontend/src/auth/register.php");
        exit;
    }
    $sql->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)");
    if (!$sql) {
        $_SESSION['message'] = '<p class="error-message">Error preparing insert query: ' . $conn->error . '</p>';
        header("Location: ../frontend/src/auth/register.php");
        exit;
    }
    $sql->bind_param('sssss', $firstname, $lastname, $username, $email, $hashed_password);

    if ($sql->execute()) {
        $_SESSION['message'] = '<p class="success-message"> Registration successful! Please log in. </p>';
        $sql->close();
        header("Location: ../frontend/src/auth/login.php");
        exit;
    } else {
        $_SESSION['message'] = '<p class="error-message"> Error registering user: ' . $sql->error . '</p>';
        $sql->close();
        header("Location: ../frontend/src/auth/register.php");
        exit;
    }
}

$conn->close();
?>