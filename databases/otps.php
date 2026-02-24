<?php
    date_default_timezone_set('Asia/Bangkok');
    function createOTPForRegister($reg_id){
        $conn = getConnection();

        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expire = date("c", strtotime("+5 minutes"));

        $sql = "insert into otps (otp_code, expires_at, reg_id) values (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if(!$stmt){
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssi", $otp, $expire, $reg_id);
        $stmt->execute();

        return $otp;
    }
    function getLatestOTPExpire($reg_id){
        $conn = getConnection();

        $sql = "select expires_at 
                from otps 
                where reg_id = ? 
                order by otp_id desc 
                limit 1";

        $stmt = $conn->prepare($sql);

        if(!$stmt){
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $reg_id);
        $stmt->execute();

        $res = $stmt->get_result()->fetch_assoc();

        return $res['expires_at'] ?? null;
    }
    function getLatestOTP($reg_id){
        $conn = getConnection();

        $sql = "select otp_code, expires_at 
                from otps 
                where reg_id = ? 
                order by otp_id desc 
                limit 1";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $reg_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
}
function verifyOTP($reg_id, $otp_code): bool {
    $conn = getConnection();

    $sql = "select otp_code, expires_at 
            from otps 
            where reg_id = ? 
            order by otp_id desc 
            limit 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reg_id);
    $stmt->execute();

    $res = $stmt->get_result()->fetch_assoc();

    if (!$res) {
        return false;
    }

    if ($res['otp_code'] === $otp_code && strtotime($res['expires_at']) > time()) {
        return true;
    }

    return false;
}