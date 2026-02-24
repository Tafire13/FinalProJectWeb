<?php
    session_start();

    const INCLUDES_DIR = __DIR__ .'/../includes';
    const ROUTES_DIR = __DIR__ .'/../routes';
    const TEMPLATES_DIR = __DIR__ .'/../templates';
    const DATABASES_DIR = __DIR__ .'/../databases';

    require_once INCLUDES_DIR . '/router.php';
    require_once INCLUDES_DIR . '/view.php';
    require_once INCLUDES_DIR . '/database.php';

    const PUBLIC_ROUTES = ['/', '/login', '/register', '/create-user', '/logout'];
    if (in_array(strtolower($_SERVER['REQUEST_URI']), PUBLIC_ROUTES)) {
        dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
        exit;
    } elseif (isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] < 3600) {
        $unix_timestamp = time();
        $_SESSION['timestamp'] = $unix_timestamp;
        dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    } else {
        unset($_SESSION['timestamp']);
        header('Location: /');
        exit;
    }
