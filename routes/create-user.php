<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm_password) {
            renderView('400', ['message' => 'Password and Confirm Password do not match']);
            exit;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $users =[
            'username' => $_POST['username'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'birthday' => $_POST['birthday'],
            'password' => $hashed_password,
            'gender' => $_POST['gender'],
            'role' => $_POST['role']
        ];
        if (insertUser($users)) {
        renderView('login', ['message' => 'ลงทะเบียนสำเร็จ']);
        } else {
            renderView('400', ['message' => 'สมัครไม่สำเร็จ']);
        }
    }