<?php
    $hostname = 'localhost';
    $nameDB = 'ticketConsert';
    $username = 'TicketDB';
    $password = 'ticket13';
    $conn = new mysqli($hostname, $username, $password, $nameDB);

    function getConnection(): mysqli {
        global $conn;
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    require_once DATABASES_DIR . '/events.php';
    require_once DATABASES_DIR . '/users.php';
    require_once DATABASES_DIR . '/images.php';
    require_once DATABASES_DIR . '/register-event.php';
    require_once DATABASES_DIR . '/otps.php';
