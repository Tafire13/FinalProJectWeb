<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $search = $_GET['search'] ?? '';
        $start  = $_GET['start_date'] ?? '';
        $end    = $_GET['end_date'] ?? '';

        $events = searchEvent($search, $start, $end);
        $uid = $_SESSION['uid'] ?? '';
        $rg = getMyRegister($uid);
        $joined = [];

        while ($row = $rg->fetch_assoc()) {
            $joined[$row['event_id']] = $row['status'];
        }

        renderView('home', [
            'events' => $events,
            'joined' => $joined,
            'uid' => $uid
        ]);
    }