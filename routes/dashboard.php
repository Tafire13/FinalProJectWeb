<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $cid = $_SESSION['uid'] ?? '';
        if(empty($cid)){
            header('Location: home');
            exit();
        }
        $event_id = $_GET['event_id'] ?? '';
        $eid = $event_id ?: null;
        
        if(!empty($event_id)){
            $result = getUsersByEventId($cid, $event_id);
        } else {
            $result = getAllUserRequireEvent($cid);
        }
        
        $stats = [
            'pending' => getPendingCount($cid, $eid),
            'confirmed' => getConfirmedCount($cid, $eid),
            'cancelled' => getCancelledCount($cid, $eid),
            'already' => getAlreadyCountByCreator($cid, $eid),
            'male' => getMaleCount($cid, $eid),
            'female' => getFemaleCount($cid, $eid),
            'other' => getOtherGenderCount($cid, $eid),
            'age_18_25' => getAge18_25Count($cid, $eid),
            'age_26_35' => getAge26_35Count($cid, $eid),
            'age_36_50' => getAge36_50Count($cid, $eid),
            'age_50_plus' => getAge50PlusCount($cid, $eid)
        ];
        
        renderView('dashboard', ['users' => $result, 'event_id' => $event_id, 'stats' => $stats]);
    }