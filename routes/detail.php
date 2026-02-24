<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $eid = $_GET['eid'] ?? '';
        if (!$eid) {
            header('Location: /');
            exit();
        }
        $event = getEventById($eid);
        if (!$event) {
            header('Location: /');
            exit();
        }
        $uid = $_SESSION['uid'] ?? null;
        $status = null;
        if ($uid) {
            $status = getMyStatusForEvent($uid, $eid);
        }
        $registered_count = getConfirmedCount($eid);
        renderView('detail', ['event' => $event, 'status' => $status, 'registered_count' => $registered_count]);
        exit();
    }