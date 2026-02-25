<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $reg_id = $_POST['reg_id'] ?? '';
        $status = $_POST['status'] ?? '';

        if(empty($reg_id) || empty($status)){
            header('Location: dashboard');
            exit();
        }

        UppdateStatusParticipants($reg_id, $status);
        
        $event_id = getEventIdByRegisterId($reg_id);
        if($event_id){
            header('Location: dashboard?event_id=' . $event_id);
        } else {
            header('Location: dashboard');
        }
        exit();
}