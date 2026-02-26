<?php
    function insertEventImage($eid, $filename){
        $conn = getConnection();
        $sql = 'insert into images(event_id, event_image) values (?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $eid, $filename);
        $result = $stmt->execute();
        return $result;
    }
    
    function deleteEventImages($eid){
        $conn = getConnection();
        $sql = 'delete from images where event_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $eid);
        $result = $stmt->execute();
        return $result;
    }
    
    function deleteEventImageByName($eid, $filename){
        $conn = getConnection();
        $sql = 'delete from images where event_id = ? AND event_image = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $eid, $filename);
        $result = $stmt->execute();
        return $result;
    }