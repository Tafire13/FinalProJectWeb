<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $uid = $_SESSION['uid'] ?? '';
        if(empty($uid)){
            header('Location: home');
            exit();
        }
        
        $result = getMyRegisterEvents($uid);
        
        renderView('events', ['events' => $result]);
    }
