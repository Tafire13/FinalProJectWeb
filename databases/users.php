<?php
    function insertUser($users): bool {
    $conn = getConnection();
    $sql = "insert into users (username, first_name, last_name, email, birthday, password, gender, role)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssssss",
        $users['username'],
        $users['first_name'],
        $users['last_name'],
        $users['email'],
        $users['birthday'],
        $users['password'],
        $users['gender'],
        $users['role']
    );
    $stmt->execute();

    return $stmt->affected_rows > 0;
    }
    function checkLogin(String $email, String $password): bool {
        $conn = getConnection();
        $sql = 'select password from users where email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return password_verify($password, $row['password']);
        }
        return false;
    }
    function getRoleUsers(String $email): String{
        $conn = getConnection();
        $sql = 'select role from users where email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['role'] ?? null;
    }
    function getIdBy(String $email): int{
        $conn = getConnection();
        $sql = 'select uid from users where email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['uid'] ?? null;
    }
    function getAllUserRequireEvent($cid){
        $conn = getConnection();

        $sql = "select re.reg_id, re.uid, re.status, u.username, u.email, u.gender, u.birthday, e.event_name, e.event_id
                from register_event re
                join events e ON re.event_id = e.event_id
                join users u ON re.uid = u.uid
                where e.cid = ?";

        $stmt = $conn->prepare($sql);

        if(!$stmt){
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param('i', $cid);
        $stmt->execute();

        return $stmt->get_result();
    }

    function getUsersByEventId($cid, $event_id){
        $conn = getConnection();

        $sql = "select re.reg_id, re.uid, re.status, u.username, u.email, u.gender, u.birthday, e.event_name, e.event_id
                from register_event re
                join events e ON re.event_id = e.event_id
                join users u ON re.uid = u.uid
                where e.cid = ? AND e.event_id = ?";

        $stmt = $conn->prepare($sql);

        if(!$stmt){
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param('ii', $cid, $event_id);
        $stmt->execute();

        return $stmt->get_result();
    }
    function getDataUserById($uid) : mysqli_result{
        $conn = getConnection();
        $sql = 'select 
                first_name, last_name, email, gender, TIMESTAMPDIFF(YEAR, birthday, CURDATE()) as age 
                from users where uid = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    