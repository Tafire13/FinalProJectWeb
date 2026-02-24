<?php

    declare(strict_types=1);
    $unix_timestamp = time();
    $_SESSION['timestamp'] = $unix_timestamp;

    header('Location: /');