<?php
    function getEventAll(): mysqli_result {
        global $conn;
        $sql = "select e.*, GROUP_CONCAT(i.event_image) as images, u.first_name, u.last_name
                from events e
                left join images i ON e.event_id = i.event_id
                left join users u ON e.cid = u.uid
                group by e.event_id";

        $result = $conn->query($sql);

        return $result;
    }
    function insertEvent($events): int{
        $conn = getConnection();
        $sql = "insert into events (event_name, description, event_date, max_participants, cid)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if(!$stmt){
            die("SQL ERROR: " . $conn->error);
        }
        $stmt->bind_param(
            'sssis',
            $events['name'],
            $events['description'],
            $events['date'],
            $events['max'],
            $events['cid']
        );
        if($stmt->execute()){
            return $conn->insert_id;
        }

        return false;
    }
    function getEventById($eid): array|null {
        global $conn;
        $sql = "select e.*, GROUP_CONCAT(i.event_image) as images, u.first_name, u.last_name
                from events e
                left join images i ON e.event_id = i.event_id
                left join users u ON e.cid = u.uid
                where e.event_id = ?
                group by e.event_id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $eid);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    function getParcitipants($eid): int{
        $conn = getConnection();
        $sql = 'select max_participants as total from events where event_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i',$eid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }
    function deleteEventById($eid): bool {
        $conn = getConnection();
        $sql = 'delete from events where event_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $eid);
        $result = $stmt->execute();
        if($result){
            return true;
        }
        return false;
    
    }
    
    function getEventByCreatorId($cid) : mysqli_result{
        $conn = getConnection();
        $sql = "select e.*, GROUP_CONCAT(i.event_image) as images, u.first_name, u.last_name
                from events e
                left join images i ON e.event_id = i.event_id
                left join users u ON e.cid = u.uid
                where cid = ?
                group by e.event_id";
        $stmt  = $conn->prepare($sql);
        $stmt->bind_param('i', $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function updateEvent($id, $name, $desc, $date, $max, $cid) : bool{
        $conn = getConnection();
        $sql = 'update events 
                set event_name = ?, description = ?, event_date = ?, max_participants = ?
                where event_id = ? AND cid = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssiii', $name, $desc, $date, $max, $id, $cid);
        $result = $stmt->execute();
        if($result){
            return true;
        }
        return false;
    }
    function searchEvent($search = '', $start = '', $end = ''): mysqli_result | bool {
    $conn = getConnection();
    $sql = "select e.*, 
                   GROUP_CONCAT(i.event_image) as images, 
                   u.first_name, u.last_name
            from events e
            left join images i ON e.event_id = i.event_id
            left join users u ON e.cid = u.uid
            where 1=1"; 
    $params = [];
    $types = "";
    if (!empty($search)) {
        $sql .= " and e.event_name LIKE ?";
        $params[] = "%{$search}%";
        $types .= "s";
    }
    if (!empty($start) && !empty($end)) {
        $sql .= " and date(e.event_date) between ? and ?";
        $params[] = $start;
        $params[] = $end;
        $types .= "ss";
    }
    elseif (!empty($start)) {
        $sql .= " and date(e.event_date) >= ?";
        $params[] = $start;
        $types .= "s";
    }
    elseif (!empty($end)) {
        $sql .= " and date(e.event_date) <= ?";
        $params[] = $end;
        $types .= "s";
    }
    $sql .= " GROUP BY e.event_id";
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}