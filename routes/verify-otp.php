<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $reg_id = $_POST['reg_id'] ?? '';
        $otp_code = $_POST['otp_code'] ?? '';

        if($reg_id && $otp_code){
            $result = verifyOTP($reg_id, $otp_code);
            if($result){
                var_dump("OTP verified for reg_id: $reg_id");
                $updateResult = UppdateStatusParticipants($reg_id, 'already');
                var_dump("Update result: ", $updateResult);
                if($updateResult){
                    header('Location: dashboard');
                    exit;
                } else {
                    echo '<script>alert("อัปเดตสถานะไม่สำเร็จ")</script>';
                }
            } else {
                echo '<script>alert("รหัส OTP ไม่ถูกต้อง")</script>';
            }
        }
    }