<?php
$eid = $_GET['eid'];
$uid = $_SESSION['uid'];

$reg = getRegisterId($uid, $eid);

if(!$reg){
    echo json_encode(['error' => 'no register']);
    exit;
}

$otpRow = getLatestOTP($reg);

if($otpRow && strtotime($otpRow['expires_at']) > time()){
    $otp = $otpRow['otp_code'];
    $expire = $otpRow['expires_at'];
}else{
    $otp = createOTPForRegister($reg);
    $expire = getLatestOTPExpire($reg);
}

echo json_encode([
    'otp' => $otp,
    'expire' => $expire
]);