<?php
declare(strict_types=1);    
session_unset();
session_destroy();
header('Location: /');
exit;
