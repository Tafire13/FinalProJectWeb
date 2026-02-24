<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $cid = $_SESSION['uid'] ?? '';
        if(empty($cid)){
            header('Location: home');
            exit();
        }
        $result = getAllUserRequireEvent($cid);
        renderView('dashboard', ['users' => $result]);
    }