<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_SESSION['uid'])) {
        $_SESSION['message'] = "กรุณาเข้าสู่ระบบก่อน";
        $_SESSION['type'] = "error";
        header('Location: /');
        exit();
    }

    $eid = $_GET['eid'] ?? '';
    $uid = $_SESSION['uid'];

    if (empty($eid)) {
        $_SESSION['message'] = "ไม่พบ event";
        $_SESSION['type'] = "error";
        header('Location: /');
        exit();
    }

    if (checkAlreadyJoin($uid, $eid)) {
        $_SESSION['message'] = $uid."คุณได้สมัครไปแล้ว".$eid;
        $_SESSION['type'] = "warning";
        header('Location: /');
        exit();
    }

    $max = getParcitipants($eid);
    $current = getConfirmedCount($eid);

    if ($current >= $max) {
        $_SESSION['message'] = "กิจกรรมนี้เต็มแล้ว";
        $_SESSION['type'] = "error";
        header('Location: /');
        exit();
    }

    $result = JoinEvent($uid, $eid);

    if ($result) {
        $_SESSION['message'] = "สมัครเข้าร่วมสำเร็จ 🎉";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['message'] = "เกิดข้อผิดพลาด";
        $_SESSION['type'] = "error";
    }

    header('Location: /');
    exit();
}
