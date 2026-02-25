<?php
function JoinEvent($uid, $eid): bool
{
    $conn = getConnection();

    $sql = 'insert into register_event (uid, event_id, status) values (?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $status = 'pending';
    $stmt->bind_param('iis', $uid, $eid, $status);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}
function getRegisterCount($eid): int
{
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)$row['total'];
}
function checkAlreadyJoin(int $uid, int $eid): bool
{
    $conn = getConnection();

    $sql = "select 1 FROM register_event WHERE uid = ? AND event_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $uid, $eid);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
}

function getMyStatusForEvent($uid, $eid): string|null
{
    $conn = getConnection();
    $sql = 'select status from register_event where uid = ? and event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $uid, $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? $row['status'] : null;
}
function getMyRegister($uid): mysqli_result
{
    $conn = getConnection();
    $sql = 'select * from  register_event where uid = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function getMyEventsWithStatus($uid): mysqli_result
{
    $conn = getConnection();
    $sql = "select re.*, e.event_name, e.event_date, e.description, e.max_participants, e.location,
            GROUP_CONCAT(i.event_image) as images
            from register_event re
            join events e ON re.event_id = e.event_id
            left join images i ON e.event_id = i.event_id
            where re.uid = ? AND re.status IN ('pending')
            group by re.reg_id, e.event_id
            order by re.reg_id desc";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    return $stmt->get_result();
}

function getMyRegisterEvents($uid): mysqli_result
{
    $conn = getConnection();
    $sql = "select re.*, e.event_name, e.event_date, e.description, e.max_participants
            from register_event re
            join events e ON re.event_id = e.event_id
            where re.uid = ? AND re.status IN ('pending', 'confirmed', 'already', 'cancelled')
            order by re.reg_id desc";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    return $stmt->get_result();
}
function UppdateStatusParticipants($reg_id, $status) : bool
{
    $conn = getConnection();

    $sql = "update register_event 
            set status = ? 
            where reg_id = ? 
            and status IN ('pending', 'confirmed')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $reg_id);

    return $stmt->execute();
}
function getAlreadyCount($eid): int
{
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event WHERE event_id = ? and status = 'already'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)$row['total'];
}
function getRegisterId($uid, $eid){
    $conn = getConnection();

    $sql = "select reg_id 
            from register_event 
            where uid = ? and event_id = ? 
            limit 1";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $uid, $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()){
        return $row['reg_id'];
    }
    return null;
}

function getEventIdByRegisterId($reg_id){
    $conn = getConnection();

    $sql = "select event_id 
            from register_event 
            where reg_id = ? 
            limit 1";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $reg_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()){
        return $row['event_id'];
    }
    return null;
}

function getPendingCount($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id WHERE e.cid = ? AND re.status = 'pending'";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getConfirmedCount($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id WHERE e.cid = ? AND re.status = 'confirmed'";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getCancelledCount($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id WHERE e.cid = ? AND re.status = 'cancelled'";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getAlreadyCountByCreator($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id WHERE e.cid = ? AND re.status = 'already'";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getMaleCount($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND u.gender = 'male'";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getFemaleCount($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND u.gender = 'female'";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getOtherGenderCount($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND (u.gender NOT IN ('male', 'female') OR u.gender IS NULL)";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}
function getAgeLess17Count($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND u.birthday IS NOT NULL AND TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) <= 17";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}
function getAge18_25Count($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND u.birthday IS NOT NULL AND TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) BETWEEN 18 AND 25";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getAge26_35Count($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND u.birthday IS NOT NULL AND TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) BETWEEN 26 AND 35";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getAge36_50Count($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND u.birthday IS NOT NULL AND TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) BETWEEN 36 AND 50";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function getAge50PlusCount($cid, $event_id = null): int {
    $conn = getConnection();
    $sql = "select COUNT(*) AS total FROM register_event re JOIN events e ON re.event_id = e.event_id JOIN users u ON re.uid = u.uid WHERE e.cid = ? AND u.birthday IS NOT NULL AND TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) > 50";
    $params = [$cid];
    $types = 'i';
    if($event_id) {
        $sql .= " AND e.event_id = ?";
        $params[] = $event_id;
        $types .= 'i';
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}