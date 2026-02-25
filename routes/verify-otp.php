<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $reg_id = $_POST['reg_id'] ?? '';
        $otp_code = $_POST['otp_code'] ?? '';

        if($reg_id && $otp_code){
            $result = verifyOTP($reg_id, $otp_code);
            if($result){
                $updateResult = UppdateStatusParticipants($reg_id, 'already');
                if($updateResult){
                    $event_id = getEventIdByRegisterId($reg_id);
                    header('Location: dashboard?event_id=' . $event_id);
                    exit;
                } else {
                    $_SESSION['error'] = 'อัปเดตสถานะไม่สำเร็จ';
                }
            } else {
                $_SESSION['error'] = 'รหัส OTP ไม่ถูกต้อง';
            }
        }
    }