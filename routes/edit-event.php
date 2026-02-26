<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['event_id'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $date = $_POST['date'];
        $max = $_POST['max'];
        $cid = $_SESSION['uid'];
        $removeImages = isset($_POST['remove_images']) ? $_POST['remove_images'] : '';

        $result = updateEvent($id, $name, $desc, $date, $max, $cid);
        
        if($result){
            // Handle image removal
            if(!empty($removeImages)){
                $imagesToRemove = explode(',', $removeImages);
                foreach($imagesToRemove as $img){
                    $img = trim($img);
                    if(!empty($img)){
                        $imgPath = 'uploads/' . $img;
                        if(file_exists($imgPath)){
                            unlink($imgPath);
                        }
                        // Delete specific image from database
                        deleteEventImageByName($id, $img);
                    }
                }
            }
            
            // Handle new image upload
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                $uploadDir = 'uploads/';
                if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $fileName;
                
                if(move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)){
                    insertEventImage($id, $fileName);
                }
            }
            
            $_SESSION['message'] = 'แก้ไขสำเร็จ';
            header("Location: creator");
            exit();
        }
        $_SESSION['error'] = 'แก้ไขไม่สำเร็จ';
        header("Location: creator");
        exit();
    }