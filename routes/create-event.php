<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $events = [
        'name' => $_POST['name'] ?? '',
        'description' => $_POST['description'] ?? '',
        'date' => $_POST['date'] ?? '',
        'max' => $_POST['max'] ?? '',
        'cid' => $_SESSION['uid'] 
    ];

    if (!$events['cid']) {
        renderView('login', ['error' => 'กรุณาเข้าสู่ระบบ']);
        exit;
    }
    $event_id = insertEvent($events);

    if ($event_id) {
        if (!empty($_FILES['event_image']['name'][0])) {
            $upload_dir = __DIR__ . '/../publics/uploads/';
            $files = $_FILES['event_image'];
            $num_files = count($files['name']);
            for ($i = 0; $i < $num_files; $i++) {
                $file_name = time() . '_' . $i . '_' . basename($files['name'][$i]);
                $target_path = $upload_dir . $file_name;
                if (move_uploaded_file($files['tmp_name'][$i], $target_path)) {
                    insertEventImage($event_id, $file_name);
                } else {}
            }
        }

        header("Location: creator");
        exit;

    } else {
        renderView('create-event', ['error' => 'ไม่สามารถสร้าง event ได้']);
    }

} else {
    renderView('create-event');
}
    