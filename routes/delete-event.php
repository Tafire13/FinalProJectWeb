<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $eid = $_GET['id'] ?? '';
        if(empty($eid)){
            header('Location: creator');
            exit();
        }
        if(deleteEventById($eid)){
            $_SESSION['message'] = 'ลบสำเร็จ';
            header('Location: creator');
            exit();
        }
    }