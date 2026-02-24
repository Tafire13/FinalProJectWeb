<?php
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $eid = $_GET['eid'];
    $uid = $_SESSION['uid'];
    $reg = getRegisterId($uid, $eid);

    if(!$reg){
        $_SESSION['message'] = "ไม่พบการสมัคร";
        $_SESSION['type'] = "error";
        header("Location: home");
        exit;
    }
    $otp = createOTPForRegister($reg);
    $expire = getLatestOTPExpire($reg);
    $_SESSION['otp_code'] = $otp;
    $_SESSION['otp_expire'] = $expire;
    $_SESSION['otp_reg'] = $reg;

    header("Location: home?showOtp=1");
    exit;
}