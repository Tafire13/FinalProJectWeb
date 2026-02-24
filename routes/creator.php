<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['uid'])) {
        header("Location: login");
        exit();
    }

    $cid = $_SESSION['uid'];
    $events = getEventByCreatorId($cid);

    renderView('creator', [
        'events' => $events
    ]);
    exit();
}