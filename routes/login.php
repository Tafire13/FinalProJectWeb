<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (checkLogin($email, $password)) {
        $unix_timestamp = time();
        $_SESSION['timestamp'] = $unix_timestamp;
        $_SESSION['email'] = $email;
        $_SESSION['uid'] = getIdBy($email);
        $_SESSION['role'] = getRoleUsers($email);
        header('Location: /');
        exit;
    } else {
        renderView('login', ['error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
        }
    } else {
        renderView('login');
    }


