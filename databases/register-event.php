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
function getConfirmedCount($eid): int
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