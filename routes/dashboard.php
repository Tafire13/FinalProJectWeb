<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $cid = $_SESSION['uid'] ?? '';
        if(empty($cid)){
            header('Location: home');
            exit();
        }
        $event_id = $_GET['event_id'] ?? '';
        if(!empty($event_id)){
            $result = getUsersByEventId($cid, $event_id);
        } else {
            $result = getAllUserRequireEvent($cid);
        }
        
        $stats = [
            'confirmed' => 0,
            'pending' => 0,
            'cancelled' => 0,
            'male' => 0,
            'female' => 0,
            'other' => 0,
            'age_18_25' => 0,
            'age_26_35' => 0,
            'age_36_50' => 0,
            'age_50_plus' => 0
        ];
        
        if($result && $result->num_rows > 0) {
            $users = [];
            while($row = $result->fetch_object()) {
                $users[] = $row;
                
                if($row->status == 'confirmed') $stats['confirmed']++;
                elseif($row->status == 'pending') $stats['pending']++;
                elseif($row->status == 'cancelled') $stats['cancelled']++;
                
                if($row->gender == 'male') $stats['male']++;
                elseif($row->gender == 'female') $stats['female']++;
                else $stats['other']++;
                
                if(!empty($row->birthday)) {
                    $age = date('Y') - date('Y', strtotime($row->birthday));
                    if($age >= 18 && $age <= 25) $stats['age_18_25']++;
                    elseif($age >= 26 && $age <= 35) $stats['age_26_35']++;
                    elseif($age >= 36 && $age <= 50) $stats['age_36_50']++;
                    elseif($age > 50) $stats['age_50_plus']++;
                }
            }
            $result->data_seek(0);
        }
        
        renderView('dashboard', ['users' => $result, 'event_id' => $event_id, 'stats' => $stats]);
    }