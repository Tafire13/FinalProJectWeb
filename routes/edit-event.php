<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['event_id'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $date = $_POST['date'];
        $max = $_POST['max'];
        $cid = $_SESSION['uid'];

        $result = updateEvent($id, $name, $desc, $date, $max, $cid);
        if($result){
            $_SESSION['message'] = 'แก้ไขสำเร็จ';
            header("Location: creator");
            exit();
        }
        $_SESSION['error'] = 'แก้ไขไม่สำเร็จ';
        header("Location: creator");
        exit();
    }