<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $uid = $_SESSION['uid'] ?? '';
        if(empty($uid)){
            header('Location: home');
            exit();
        }
        
        $events = getMyRegisterEvents($uid);
        
        renderView('my-event', ['events' => $events]);
    }