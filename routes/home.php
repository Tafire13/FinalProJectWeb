<?php
$uid = $_SESSION['uid'] ?? '';
$events = getEventAll();
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
