<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $uid = $_SESSION['uid'];
        $user = getDataUserById($uid);
        renderView('profile', ['user' => $user]);
    }
?>