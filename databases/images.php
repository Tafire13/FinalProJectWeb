<?php
    function insertEventImage($eid, $filename){
        $conn = getConnection();
        $sql = 'insert into images(event_id, event_image) values (?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $eid, $filename);
        $result = $stmt->execute();
        return $result;
    } 